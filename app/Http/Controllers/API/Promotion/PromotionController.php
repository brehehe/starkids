<?php

namespace App\Http\Controllers\API\Promotion;

use App\Http\Controllers\Controller;
use App\Models\Promotion\PromotionEvent;
use App\Services\Promotion\PromotionService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    /**
     * Get available promotions for customer
     */
    public function getAvailablePromotions(Request $request): JsonResponse
    {
        try {
            $customerId = $request->user()->id;
            $companyId = $request->user()->company_id;

            $promotions = $this->promotionService->getAvailablePromotions($customerId, $companyId);

            return response()->json([
                'success' => true,
                'data' => $promotions->map(function ($promotion) {
                    return [
                        'id' => $promotion->id,
                        'code' => $promotion->code,
                        'name' => $promotion->name,
                        'description' => $promotion->description,
                        'type' => $promotion->type,
                        'discount_value' => $promotion->discount_value,
                        'minimum_purchase' => $promotion->minimum_purchase,
                        'maximum_discount' => $promotion->maximum_discount,
                        'start_date' => $promotion->start_date->format('Y-m-d H:i:s'),
                        'end_date' => $promotion->end_date->format('Y-m-d H:i:s'),
                        'is_featured' => $promotion->is_featured,
                        'auto_apply' => $promotion->auto_apply,
                        'remaining_usage' => $promotion->remaining_usage,
                        'terms_conditions' => $promotion->terms_conditions,
                        'image' => $promotion->image,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get promotions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Apply promotion to order
     */
    public function applyPromotion(Request $request): JsonResponse
    {
        $request->validate([
            'promotion_code' => 'required|string',
            'order_amount' => 'required|numeric|min:0',
            'products' => 'array',
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        try {
            $customerId = $request->user()->id;
            $result = $this->promotionService->applyPromotion(
                $request->promotion_code,
                $customerId,
                $request->order_amount,
                $request->products ?? []
            );

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'promotion_id' => $result['promotion']->id,
                        'promotion_name' => $result['promotion']->name,
                        'discount_amount' => $result['discount_amount'],
                        'final_amount' => $result['final_amount'],
                        'message' => $result['message'],
                    ],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply promotion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get auto-applicable promotions
     */
    public function getAutoPromotions(Request $request): JsonResponse
    {
        $request->validate([
            'order_amount' => 'required|numeric|min:0',
            'products' => 'array',
        ]);

        try {
            $customerId = $request->user()->id;
            $companyId = $request->user()->company_id;

            $promotions = $this->promotionService->getAutoApplicablePromotions(
                $customerId,
                $companyId,
                $request->order_amount,
                $request->products ?? []
            );

            return response()->json([
                'success' => true,
                'data' => $promotions->map(function ($promotion) {
                    $discountResult = $promotion->calculateDiscount(
                        request('order_amount'),
                        request('products', [])
                    );

                    return [
                        'id' => $promotion->id,
                        'code' => $promotion->code,
                        'name' => $promotion->name,
                        'type' => $promotion->type,
                        'discount_amount' => $discountResult['discount_amount'],
                        'final_amount' => $discountResult['final_amount'],
                        'message' => $discountResult['message'],
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get auto promotions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Get all promotions
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $companyId = $request->user()->company_id;

            $query = PromotionEvent::where('company_id', $companyId)
                ->with(['creator', 'usageHistories']);

            // Filter by status
            if ($request->has('status')) {
                switch ($request->status) {
                    case 'active':
                        $query->active();
                        break;
                    case 'current':
                        $query->current();
                        break;
                    case 'expired':
                        $query->where('end_date', '<', Carbon::now());
                        break;
                }
            }

            // Filter by type
            if ($request->has('type')) {
                $query->byType($request->type);
            }

            // Search by name or code
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            }

            $promotions = $query->orderBy('created_at', 'desc')
                ->paginate($request->get('per_page', 15));

            return response()->json([
                'success' => true,
                'data' => $promotions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get promotions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Create promotion
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'nullable|string|max:50|unique:promotions,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => [
                'required',
                Rule::in(['percentage', 'fixed_amount', 'buy_x_get_y', 'free_shipping', 'bundle', 'cashback', 'loyalty_points']),
            ],
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'discount_value' => 'nullable|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'customer_type' => [
                'required',
                Rule::in(['all', 'new', 'existing', 'vip', 'specific']),
            ],
            'applicable_to' => [
                'required',
                Rule::in(['all_products', 'specific_products', 'categories', 'services']),
            ],
            'auto_apply' => 'boolean',
            'is_featured' => 'boolean',
            'terms_conditions' => 'nullable|array',
        ]);

        try {
            // Validate promotion dates
            $dateErrors = $this->promotionService->validatePromotionDates(
                $request->start_date,
                $request->end_date
            );

            if (! empty($dateErrors)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $dateErrors,
                ], 422);
            }

            $promotion = $this->promotionService->createPromotion($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Promotion created successfully',
                'data' => $promotion,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create promotion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Show promotion details
     */
    public function show($id): JsonResponse
    {
        try {
            $promotion = PromotionEvent::with(['creator', 'updater', 'usageHistories.customer'])
                ->findOrFail($id);

            $analytics = $this->promotionService->getPromotionAnalytics($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'promotion' => $promotion,
                    'analytics' => $analytics,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Promotion not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Admin: Update promotion
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'discount_value' => 'nullable|numeric|min:0',
            'minimum_purchase' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        try {
            $promotion = $this->promotionService->updatePromotion($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Promotion updated successfully',
                'data' => $promotion,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update promotion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Delete promotion
     */
    public function destroy($id): JsonResponse
    {
        try {
            $promotion = PromotionEvent::findOrFail($id);
            $promotion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promotion deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete promotion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Clone promotion
     */
    public function clone(Request $request, $id): JsonResponse
    {
        try {
            $overrides = $request->only(['name', 'start_date', 'end_date']);
            $clonedPromotion = $this->promotionService->clonePromotion($id, $overrides);

            return response()->json([
                'success' => true,
                'message' => 'Promotion cloned successfully',
                'data' => $clonedPromotion,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clone promotion',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Admin: Get promotion analytics summary
     */
    public function analytics(Request $request): JsonResponse
    {
        try {
            $companyId = $request->user()->company_id;
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $summary = $this->promotionService->getCompanyPromotionSummary(
                $companyId,
                $startDate,
                $endDate
            );

            return response()->json([
                'success' => true,
                'data' => $summary,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get analytics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
