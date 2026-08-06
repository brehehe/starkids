<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Account{
/**
 * @property string $id
 * @property string $category_account_id
 * @property string $name
 * @property string $code
 * @property bool $is_cash
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account\AccountTransaction> $accountTransactions
 * @property-read int|null $account_transactions_count
 * @property-read \App\Models\Account\CategoryAccount|null $categoryAccount
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCategoryAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIsCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account withoutTrashed()
 */
	class Account extends \Eloquent {}
}

namespace App\Models\Account{
/**
 * @property string $id
 * @property string $finance_id
 * @property string|null $finance_item_id
 * @property string|null $finance_other_id
 * @property string|null $finance_recipe_id
 * @property string|null $finance_payment_id
 * @property string|null $journal_id
 * @property string|null $journal_item_id
 * @property string $account_id
 * @property numeric $debit
 * @property numeric $credit
 * @property string|null $description
 * @property string|null $date
 * @property string $type
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account\Account|null $account
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Journal\Journal|null $journal
 * @property-read \App\Models\Journal\JournalItem|null $journalItem
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereFinanceItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereFinanceOtherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereFinancePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereFinanceRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereJournalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereJournalItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountTransaction withoutTrashed()
 */
	class AccountTransaction extends \Eloquent {}
}

namespace App\Models\Account{
/**
 * @property string $id
 * @property string $name
 * @property string $detail_category_account_id
 * @property string $cash_flow
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account\Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Account\DetailCategoryAccount|null $detailCategoryAccount
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereCashFlow($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereDetailCategoryAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoryAccount withoutTrashed()
 */
	class CategoryAccount extends \Eloquent {}
}

namespace App\Models\Account{
/**
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account\CategoryAccount> $categoryAccounts
 * @property-read int|null $category_accounts_count
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailCategoryAccount withoutTrashed()
 */
	class DetailCategoryAccount extends \Eloquent {}
}

namespace App\Models\Admin\Hr{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Database\Factories\Admin\Hr\ShiftFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withoutTrashed()
 */
	class Shift extends \Eloquent {}
}

namespace App\Models\Api{
/**
 * @property string $id
 * @property array<array-key, mixed> $model_classes Untuk menyimpan class model
 * @property array<array-key, mixed> $model_ids Untuk menyimpan id model
 * @property string $service_class Untuk menyimpan class service
 * @property string $service_method Untuk menyimpan function service
 * @property string|null $request_body menyimpan data request
 * @property string|null $response_body menyimpan data response
 * @property string $status status antrian api
 * @property int $execution jumlah perulangan model dengan service yang sama
 * @property string|null $execute_at waktu eksekusi data api
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereExecuteAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereExecution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereModelClasses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereModelIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereResponseBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereServiceClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereServiceMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApiOutboxTask withoutTrashed()
 */
	class ApiOutboxTask extends \Eloquent {}
}

namespace App\Models\Article{
/**
 * @property string $id
 * @property string $company_id
 * @property string|null $article_category_id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property string|null $banner
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Article\ArticleCategory|null $category
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereArticleCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Article withoutTrashed()
 */
	class Article extends \Eloquent {}
}

namespace App\Models\Article{
/**
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article\Article> $articles
 * @property-read int|null $articles_count
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ArticleCategory withoutTrashed()
 */
	class ArticleCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $clock_in_time
 * @property numeric|null $clock_in_location_lat
 * @property numeric|null $clock_in_location_long
 * @property string|null $clock_in_photo_path
 * @property string|null $clock_out_time
 * @property numeric|null $clock_out_location_lat
 * @property numeric|null $clock_out_location_long
 * @property string|null $clock_out_photo_path
 * @property string $status
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $location
 * @property string|null $clock_out_location
 * @property string|null $reason
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockInLocationLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockInLocationLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockInPhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockOutLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockOutLocationLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockOutLocationLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockOutPhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereClockOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attendance withoutTrashed()
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $attendance_id
 * @property string $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $timestamp
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $location_address
 * @property string|null $photo_path
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attendance|null $attendance
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereLocationAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AttendanceHistory whereUserId($value)
 */
	class AttendanceHistory extends \Eloquent {}
}

namespace App\Models\Banner{
/**
 * @property string $id
 * @property string $company_id
 * @property string $image
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner withoutTrashed()
 */
	class Banner extends \Eloquent {}
}

namespace App\Models\Branch{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withoutTrashed()
 */
	class Branch extends \Eloquent {}
}

namespace App\Models\Cash{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $description
 * @property numeric $amount
 * @property numeric $amount_real
 * @property numeric $remaining_bill
 * @property string|null $company_id
 * @property string $start_date
 * @property string|null $end_date
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereAmountReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereRemainingBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cash withoutTrashed()
 */
	class Cash extends \Eloquent {}
}

namespace App\Models\Company{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $service_id
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $tax_id
 * @property string|null $industry
 * @property string|null $description
 * @property string|null $pic_name
 * @property string|null $pic_position
 * @property string|null $pic_email
 * @property string|null $pic_phone
 * @property bool $is_active
 * @property string|null $expires_at
 * @property int $duration_days
 * @property string|null $start_date
 * @property bool $is_central
 * @property bool $is_main
 * @property bool $is_lifetime
 * @property string|null $one_health_access_token save auth access token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property string|null $code_health_facility
 * @property bool $is_editable_price_pos
 * @property bool $with_pharmacy
 * @property string|null $icon Path atau URL icon perusahaan
 * @property string|null $work_days
 * @property string|null $clock_in_time
 * @property string|null $clock_out_time
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property int|null $attendance_radius in meters
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Company> $companies
 * @property-read int|null $companies_count
 * @property-read Company|null $company
 * @property-read \App\Models\Company\CompanyDetail|null $companyDetail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\Condition> $conditions
 * @property-read int|null $conditions_count
 * @property-read string $name_main
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDispenseRequest> $medicationReqDispanse
 * @property-read int|null $medication_req_dispanse_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\Medication> $medications
 * @property-read int|null $medications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicineType\MedicineType> $medicineTypes
 * @property-read int|null $medicine_types_count
 * @property-read \App\Models\Company\OneHealthy|null $oneHealthy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\PatientCompany> $patientCompany
 * @property-read int|null $patient_company_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $performerMedicationDispenses
 * @property-read int|null $performer_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $requestMedicationReqs
 * @property-read int|null $request_medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAttendanceRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereClockInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereClockOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCodeHealthFacility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsCentral($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsEditablePricePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereOneHealthAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePicEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePicPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePicPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWithPharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWorkDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutTrashed()
 */
	class Company extends \Eloquent {}
}

namespace App\Models\Company{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $one_health_code Kode satusehat
 * @property string|null $facility_code Kode sarana by one health
 * @property string|null $organization_id Nomor organisasi by one health
 * @property string|null $province_code Kode provinsi by one health
 * @property string|null $province
 * @property string|null $city_code Kode kabupaten by one health
 * @property string|null $city
 * @property string|null $district_code Kode kecamatan by one health
 * @property string|null $district
 * @property string|null $sub_district_code Kode kelurahan by one health
 * @property string|null $sub_district
 * @property string|null $postal_code
 * @property string|null $address
 * @property string $country
 * @property string|null $rt Kode RT by one health
 * @property string|null $rw Kode RW by one health
 * @property string $longitude Kode longitude by one health
 * @property string $latitude Kode latitude by one health
 * @property string $altitude Kode altitude by one health
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereFacilityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereOneHealthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereSubDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereSubDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyDetail withoutTrashed()
 */
	class CompanyDetail extends \Eloquent {}
}

namespace App\Models\Company{
/**
 * @property string $id
 * @property string $company_id
 * @property string $service_month_id
 * @property string $start_date
 * @property string|null $expires_at
 * @property int $duration_days
 * @property int $order
 * @property bool $is_lifetime
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\CompanyServiceMonth> $companyServiceMonths
 * @property-read int|null $company_service_months_count
 * @property-read \App\Models\Service\Service|null $service
 * @property-read \App\Models\Service\ServiceMonth|null $serviceMonth
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereIsLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereServiceMonthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyService withoutTrashed()
 */
	class CompanyService extends \Eloquent {}
}

namespace App\Models\Company{
/**
 * @property string $id
 * @property string $company_service_id
 * @property string $service_month_id
 * @property string $start_date
 * @property int $duration_days
 * @property string|null $expires_at
 * @property bool $is_lifetime
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereCompanyServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereIsLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereServiceMonthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanyServiceMonth withoutTrashed()
 */
	class CompanyServiceMonth extends \Eloquent {}
}

namespace App\Models\Company\OneHealth{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $id_organization ID organisasi dari satu sehat
 * @property bool $active Berisi data status keaktifan data organisasi dengan tipe data boolean.
 * @property string $type_coding_system Berisi data tipe organisasi dengan tipe data CodeableConcept.
 * @property string $type_coding_code Berisi data tipe organisasi dengan tipe data CodeableConcept.
 * @property string $type_coding_display Berisi data tipe organisasi dengan tipe data CodeableConcept.
 * @property string $name Berisi data nama organisasi dengan tipe data string.
 * @property string|null $part_of_reference organisasi bagian dari organisasi lain (suborganisasi) dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OneHealthOrganization> $OHConditions
 * @property-read int|null $o_h_conditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEncounter> $OHEncounter
 * @property-read int|null $o_h_encounter_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocation> $OHLocations
 * @property-read int|null $o_h_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseIdentifier> $OHMedicationDispenseIdentifiers
 * @property-read int|null $o_h_medication_dispense_identifiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\OneHealth\OneHealthMedicationIdentifier> $OHMedicationIdentifiers
 * @property-read int|null $o_h_medication_identifiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest> $OHMedicationReqDispenseRequest
 * @property-read int|null $o_h_medication_req_dispense_request_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestIdentifier> $OHMedicationReqIdentifiers
 * @property-read int|null $o_h_medication_req_identifiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OneHealthOrganization> $OHMedicationReqs
 * @property-read int|null $o_h_medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservation> $OHObservation
 * @property-read int|null $o_h_observation_count
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganizationAddress|null $OHOrganizationAddress
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganizationIdentifier|null $OHOrganizationIdentifier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\OneHealth\OneHealthOrganizationTelecom> $OHOrganizationTelecoms
 * @property-read int|null $o_h_organization_telecoms_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Master\CodeSystem\Organization\MasterOrganizationType|null $typeCodingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereIdOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization wherePartOfReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereTypeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereTypeCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganization withoutTrashed()
 */
	class OneHealthOrganization extends \Eloquent {}
}

namespace App\Models\Company\OneHealth{
/**
 * @property string $id
 * @property string $one_health_organization_id
 * @property \App\Models\Master\CodeSystem\Organization\MasterOrganizationAddressUse|null $use Berisi data penggunaan alamat organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi AddressUse.
 * @property \App\Models\Master\CodeSystem\Organization\MasterOrganizationAddressType|null $type Berisi data jenis alamat organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi AddressType
 * @property string $line Berisi satu atau lebih data nama, blok, no jalan atau no rumah dengan tipe data string.
 * @property string $city Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.
 * @property string|null $postal_code Berisi data kode pos dengan tipe data string.
 * @property string $country Berisi data kode negara berdasarkan ISO 3316 2-letter (contoh: ID) dengan dengan tipe data string.
 * @property string $extention_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\OneHealth\OneHealthOrganizationAddressExtention> $extentions
 * @property-read int|null $extentions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereExtentionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddress withoutTrashed()
 */
	class OneHealthOrganizationAddress extends \Eloquent {}
}

namespace App\Models\Company\OneHealth{
/**
 * @property string $id
 * @property string $one_health_organization_address_id
 * @property string $url Source of the definition for the extension code - a logical name or a URL. value : province/city/district/village
 * @property string|null $value_code value of master data region
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganizationAddress|null $OHOrganizationAddress
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereOneHealthOrganizationAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention whereValueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationAddressExtention withoutTrashed()
 */
	class OneHealthOrganizationAddressExtention extends \Eloquent {}
}

namespace App\Models\Company\OneHealth{
/**
 * @property string $id
 * @property string $one_health_organization_id
 * @property \App\Models\Master\CodeSystem\Organization\MasterOrganizationIndentifierUse|null $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse
 * @property string $system Di mana isi dari parameter {organization-ihs-number} adalah ID organisasi induk yang didapatkan dari master sarana indeks.
 * @property string $value Berisi kode atau nomor internal sub organisasi. (value of one_health_organization.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationIdentifier withoutTrashed()
 */
	class OneHealthOrganizationIdentifier extends \Eloquent {}
}

namespace App\Models\Company\OneHealth{
/**
 * @property string $id
 * @property string $one_health_organization_id
 * @property \App\Models\Master\CodeSystem\Organization\MasterOrganizationContactPointSystem|null $system Berisi data jenis kontak dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointSystem.
 * @property string $value Berisi data nomor/email/website kontak organisasi dengan tipe data string.
 * @property \App\Models\Master\CodeSystem\Organization\MasterOrganizationContactPointUse|null $use Berisi data penggunaan kontak organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointUse.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthOrganizationTelecom withoutTrashed()
 */
	class OneHealthOrganizationTelecom extends \Eloquent {}
}

namespace App\Models\Company{
/**
 * @property string $id
 * @property string $company_id
 * @property string|null $organization_id
 * @property string|null $client_id
 * @property string|null $client_secret
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereClientSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthy withoutTrashed()
 */
	class OneHealthy extends \Eloquent {}
}

namespace App\Models\Condition{
/**
 * @property string $id
 * @property string|null $transaction_condition_id
 * @property string|null $company_id
 * @property string|null $condition_id
 * @property string|null $patient_id
 * @property string|null $encounter_id
 * @property string $clinical_status Berisi satu atau lebih data kode status klinis dari kondisi pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionClinicalStatusCodes.
 * @property string $category Berisi satu atau lebih data kode kategori kondisi apakah problem atau keluhan yang dirasakan pasien (diagnosis pasien) dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionCategoryCodes.
 * @property string $code Berisi kode diagnosis dengan tipe data CodeableConcept, yang nilainya mengacu pada dua data terminologi ICD-10 tahun 2010 (untuk melaporkan terkait diagnosis pasien saat kunjungan) dan http://terminology.kemkes.go.id/CodeSystem/clinical-term (untuk melaporkan kondisi saat meninggalkan rumah sakit).
 * @property string|null $onset_date_time Berisi data mengenai kapan kondisi dimulai menurut pendapat dokter
 * @property string|null $recorded_date Berisi data kondisi yang menunjukkan kapan Kondisi/keluhan ini tercatat dalam sistem
 * @property array<array-key, mixed>|null $notes Berisi satu atau lebih data informasi tambahan tentang Kondisi/ Keluhan/ Penyakit
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthCondition|null $OHCondition
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereOnsetDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereRecordedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereTransactionConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Condition withoutTrashed()
 */
	class Condition extends \Eloquent {}
}

namespace App\Models\Condition\OneHealth{
/**
 * @property string $id
 * @property string|null $condition_id
 * @property string|null $id_condition
 * @property string|null $one_health_organization_id
 * @property string|null $one_health_patient_id
 * @property string|null $one_health_encounter_id
 * @property string $subject_reference Berisi data subjek dari kondisi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $subject_display Berisi data subjek dari kondisi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $encounter_reference Berisi data informasi terkait kunjungan di mana diagnosis ditegakkan yang setiap datanya direpresentasikan dengan tipe data Reference yang direferensikan ke data yang tersimpan di resources Encounter
 * @property string|null $encounter_display Berisi data informasi terkait kunjungan di mana diagnosis ditegakkan yang setiap datanya direpresentasikan dengan tipe data Reference yang direferensikan ke data yang tersimpan di resources Encounter
 * @property string|null $onset_date_time Berisi data mengenai kapan kondisi dimulai menurut pendapat dokter
 * @property string|null $recorded_date Berisi data kondisi yang menunjukkan kapan Kondisi/keluhan ini tercatat dalam sistem
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthConditionCategory|null $OHConditionCategory
 * @property-read \App\Models\Condition\OneHealth\OneHealthConditionClinicalStatus|null $OHConditionClinicalStatus
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionCode> $OHConditionCodes
 * @property-read int|null $o_h_condition_codes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionNote> $OHConditionNotes
 * @property-read int|null $o_h_condition_notes_count
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \App\Models\Condition\Condition|null $condition
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereEncounterDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereEncounterReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereIdCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereOnsetDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereRecordedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereSubjectDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereSubjectReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthCondition withoutTrashed()
 */
	class OneHealthCondition extends \Eloquent {}
}

namespace App\Models\Condition\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_condition_id
 * @property string $coding_system Berisi satu atau lebih data kode kategori kondisi apakah problem atau keluhan yang dirasakan pasien (diagnosis pasien) dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionCategoryCodes.
 * @property string $coding_code Berisi satu atau lebih data kode kategori kondisi apakah problem atau keluhan yang dirasakan pasien (diagnosis pasien) dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionCategoryCodes.
 * @property string $coding_display Berisi satu atau lebih data kode kategori kondisi apakah problem atau keluhan yang dirasakan pasien (diagnosis pasien) dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionCategoryCodes.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthCondition|null $OHCondition
 * @property-read \App\Models\Master\CodeSystem\Condition\MasterConditionCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereOneHealthConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCategory withoutTrashed()
 */
	class OneHealthConditionCategory extends \Eloquent {}
}

namespace App\Models\Condition\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_condition_id
 * @property string $coding_system Berisi satu atau lebih data kode status klinis dari kondisi pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionClinicalStatusCodes.
 * @property string $coding_code Berisi satu atau lebih data kode status klinis dari kondisi pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionClinicalStatusCodes.
 * @property string $coding_display Berisi satu atau lebih data kode status klinis dari kondisi pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi ConditionClinicalStatusCodes.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthCondition|null $OHCondition
 * @property-read \App\Models\Master\CodeSystem\Condition\MasterConditionClinicalStatus|null $clinical
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereOneHealthConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionClinicalStatus withoutTrashed()
 */
	class OneHealthConditionClinicalStatus extends \Eloquent {}
}

namespace App\Models\Condition\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_condition_id
 * @property string $coding_system Berisi kode diagnosis dengan tipe data CodeableConcept, yang nilainya mengacu pada dua data terminologi ICD-10 tahun 2010 (untuk melaporkan terkait diagnosis pasien saat kunjungan) dan http://terminology.kemkes.go.id/CodeSystem/clinical-term (untuk melaporkan kondisi saat meninggalkan rumah sakit).
 * @property string $coding_code Berisi kode diagnosis dengan tipe data CodeableConcept, yang nilainya mengacu pada dua data terminologi ICD-10 tahun 2010 (untuk melaporkan terkait diagnosis pasien saat kunjungan) dan http://terminology.kemkes.go.id/CodeSystem/clinical-term (untuk melaporkan kondisi saat meninggalkan rumah sakit).
 * @property string $coding_display Berisi kode diagnosis dengan tipe data CodeableConcept, yang nilainya mengacu pada dua data terminologi ICD-10 tahun 2010 (untuk melaporkan terkait diagnosis pasien saat kunjungan) dan http://terminology.kemkes.go.id/CodeSystem/clinical-term (untuk melaporkan kondisi saat meninggalkan rumah sakit).
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthCondition|null $OHCondition
 * @property-read \App\Models\Master\CodeSystem\Condition\MasterConditionCodeChiefComplaint|null $chiefComplaint
 * @property-read \App\Models\Icd\Icd10|null $icd10
 * @property-read \App\Models\Master\CodeSystem\Condition\MasterConditionCodePreviousCondition|null $previousCondition
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereOneHealthConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionCode withoutTrashed()
 */
	class OneHealthConditionCode extends \Eloquent {}
}

namespace App\Models\Condition\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_condition_id
 * @property string $text Berisi satu atau lebih data informasi tambahan tentang Kondisi/ Keluhan/ Penyakit
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Condition\OneHealth\OneHealthCondition|null $OHCondition
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereOneHealthConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthConditionNote withoutTrashed()
 */
	class OneHealthConditionNote extends \Eloquent {}
}

namespace App\Models\Country{
/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withoutTrashed()
 */
	class Country extends \Eloquent {}
}

namespace App\Models\DeadStock{
/**
 * @property string $id
 * @property string|null $branch_id
 * @property string $product_id
 * @property string $name
 * @property int $quantity_old
 * @property int $quantity
 * @property numeric $price
 * @property numeric $total
 * @property string $status
 * @property string|null $company_id
 * @property bool $is_process_finance
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereIsProcessFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereQuantityOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeadStock withoutTrashed()
 */
	class DeadStock extends \Eloquent {}
}

namespace App\Models\Defecta{
/**
 * @property string $id
 * @property string $product_stock_id
 * @property string $product_id
 * @property string $branch_id
 * @property int $minimum_stock
 * @property int|null $edited_minimum_stock
 * @property string $status
 * @property string|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductStock|null $productStock
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta search($term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereEditedMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereProductStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Defecta withoutTrashed()
 */
	class Defecta extends \Eloquent {}
}

namespace App\Models\Deposit{
/**
 * @property string $id
 * @property string $code
 * @property string|null $patient_id
 * @property string|null $user_type_id
 * @property string|null $patient_company_role_id
 * @property string|null $text
 * @property string|null $description
 * @property numeric $quantity_request
 * @property numeric $quantity_free
 * @property numeric $quantity
 * @property numeric $remaining_quantity
 * @property numeric $sub_total_price
 * @property numeric $grand_total_price
 * @property numeric $remaining_bill
 * @property numeric $payment_change
 * @property string $status
 * @property string|null $created_by
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deposit\DepositItem> $depositItems
 * @property-read int|null $deposit_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deposit\DepositPayment> $depositPayments
 * @property-read int|null $deposit_payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deposit\DepositRecipe> $depositRecipes
 * @property-read int|null $deposit_recipes_count
 * @property-read mixed $status_badge
 * @property-read mixed $status_label
 * @property-read \App\Models\User|null $patient
 * @property-read \App\Models\User\UserCompanyRole|null $patientCompanyRole
 * @property-read \App\Models\User\UserType|null $userType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit byPatient($patientId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereGrandTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit wherePatientCompanyRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit wherePaymentChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereQuantityFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereQuantityRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereRemainingBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereRemainingQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit whereUserTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deposit withoutTrashed()
 */
	class Deposit extends \Eloquent {}
}

namespace App\Models\Deposit{
/**
 * @property string $id
 * @property string|null $deposit_id
 * @property string|null $deposit_item_id
 * @property string|null $deposit_recipe_id
 * @property string|null $branch_id
 * @property string|null $user_id
 * @property string $type
 * @property numeric $dosage_doctor
 * @property numeric $doctor_dosage_gram
 * @property int $dosage_drug
 * @property string|null $name
 * @property string|null $product_id
 * @property string|null $product_package_id
 * @property string|null $company_id
 * @property numeric $quantity_real
 * @property numeric $price
 * @property numeric $price_discount
 * @property numeric $price_hpp
 * @property int $quantity
 * @property numeric $discount
 * @property numeric $sub_total_price
 * @property numeric $sub_total_price_hpp
 * @property bool $is_narcotic
 * @property bool $is_free_item
 * @property string|null $user_asign_narcotic_id
 * @property string $type_transaction
 * @property bool $is_outside_pharmacy
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Deposit\Deposit|null $deposit
 * @property-read DepositItem|null $depositItem
 * @property-read \App\Models\Deposit\DepositRecipe|null $depositRecipe
 * @property-read mixed $type_label
 * @property-read mixed $type_transaction_label
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductPackage|null $productPackage
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User|null $userAssignNarcotic
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDepositItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDepositRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDoctorDosageGram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDosageDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereDosageDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereIsFreeItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereIsNarcotic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereIsOutsidePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereProductPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereSubTotalPriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereTypeTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereUserAsignNarcoticId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositItem withoutTrashed()
 */
	class DepositItem extends \Eloquent {}
}

namespace App\Models\Deposit{
/**
 * @property string $id
 * @property string $deposit_id
 * @property string|null $user_id
 * @property string $payment_method_id
 * @property string|null $description
 * @property numeric $admin_fee
 * @property numeric $payment_amount
 * @property numeric $payment_real
 * @property bool $is_single_payment
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Deposit\Deposit|null $deposit
 * @property-read \App\Models\PaymentMethod\PaymentMethod|null $paymentMethod
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereIsSinglePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment wherePaymentReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositPayment withoutTrashed()
 */
	class DepositPayment extends \Eloquent {}
}

namespace App\Models\Deposit{
/**
 * @property string $id
 * @property string|null $recipe_id
 * @property string|null $medicine_type_id
 * @property string|null $branch_id
 * @property int $numero_recipe
 * @property numeric $price_service_one
 * @property numeric $price_service_other
 * @property string|null $product_id
 * @property int $quantity
 * @property numeric $price
 * @property numeric $price_discount
 * @property numeric $price_hpp
 * @property numeric $sub_total_price
 * @property numeric $sub_total_price_hpp
 * @property string|null $how_to_use_id
 * @property string|null $description
 * @property string|null $route_coding_code
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Deposit\Deposit|null $deposit
 * @property-read \App\Models\HowToUse\HowToUse|null $howToUse
 * @property-read \App\Models\MedicineType\MedicineType|null $medicineType
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereHowToUseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereMedicineTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereNumeroRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe wherePriceServiceOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe wherePriceServiceOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereRouteCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereSubTotalPriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DepositRecipe withoutTrashed()
 */
	class DepositRecipe extends \Eloquent {}
}

namespace App\Models\Discount{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $discount_type
 * @property numeric $discount_value
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Discount withoutTrashed()
 */
	class Discount extends \Eloquent {}
}

namespace App\Models\Doctor{
/**
 * @property string $id
 * @property string $name
 * @property string|null $specialization
 * @property string|null $hospital
 * @property string $type
 * @property string|null $user_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereHospital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Doctor withoutTrashed()
 */
	class Doctor extends \Eloquent {}
}

namespace App\Models\Doctor{
/**
 * @property string $id
 * @property string $product_id
 * @property string $user_id
 * @property string $type_incentive
 * @property numeric $incentive_value
 * @property string|null $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereIncentiveValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereTypeIncentive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorActionIncentive withoutTrashed()
 */
	class DoctorActionIncentive extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $company_id
 * @property string|null $location_id
 * @property string|null $patient_id
 * @property string $type Type untuk kunjungan rawat jalan atau rawat inap
 * @property \App\Models\Master\CodeSystem\Encounter\MasterEncounterStatus|null $status Berisi data status tahapan dari pertemuan pasien dengan tipe data code, yang nilainya mengacu pada data terminologi EncounterStatus
 * @property string $class_code Berisi data klasifikasi dari pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ActEncounterCode.
 * @property string|null $period_start Diisi dengan waktu mulai, sama dengan waktu kedatangan pasien dengan tipe data dateTime
 * @property string|null $period_end Diisi dengan waktu mulai, sama dengan waktu kepulangan pasien dengan tipe data dateTime
 * @property string|null $hospital_discharge_text Catatan setelah pasien dipulangkan
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Master\CodeSystem\Encounter\MasterEncounterActCode|null $classCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\EncounterClassHistory> $classHistories
 * @property-read int|null $class_histories_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\Condition> $conditions
 * @property-read int|null $conditions_count
 * @property-read \App\Models\Encounter\EncounterCondition|null $encounterConditon
 * @property-read \App\Models\Encounter\EncounterPractitiont|null $encounterPractitiont
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\EncounterStatusHistory> $statusHistories
 * @property-read int|null $status_histories_count
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereClassCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereHospitalDischargeText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Encounter withoutTrashed()
 */
	class Encounter extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string|null $encounter_id
 * @property string $class_code Berisi data klasifikasi dari pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ActEncounterCode.
 * @property \Illuminate\Support\Carbon|null $period_start Diisi dengan waktu mulai, sama dengan waktu dimulainya suatu klasifikasi kunjungan dalam format YYYY-MM-DD.
 * @property \Illuminate\Support\Carbon|null $period_end Diisi dengan waktu selesai, sama dengan waktu berakhirnya suatu klasifikasi kunjungan dalam format YYYY-MM-DD.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Master\CodeSystem\Encounter\MasterEncounterActCode|null $classCode
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereClassCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterClassHistory withoutTrashed()
 */
	class EncounterClassHistory extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string $encounter_id
 * @property string|null $transaction_id
 * @property string|null $transaction_primary_id
 * @property string|null $description
 * @property string|null $verification_status
 * @property string|null $clinical_status
 * @property string|null $snomed_code
 * @property string|null $onset_datetime
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereOnsetDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereSnomedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereTransactionPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition whereVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterCondition withoutTrashed()
 */
	class EncounterCondition extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string $encounter_id
 * @property string $encounter_condition_id
 * @property string|null $transaction_icd10_id
 * @property string $icd10_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereEncounterConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereTransactionIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterConditionIcd10 withoutTrashed()
 */
	class EncounterConditionIcd10 extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string|null $encounter_id
 * @property string|null $practitioner_id
 * @property string $type_coding_code Berisi satu atau lebih data partisipan pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ParticipantType.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Practitiont\Practitioner|null $practitioner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterPractitiont withoutTrashed()
 */
	class EncounterPractitiont extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string|null $encounter_id
 * @property \App\Models\Master\CodeSystem\Encounter\MasterEncounterStatus|null $status Berisi data status tahapan dari pertemuan pasien dengan tipe data code, yang nilainya mengacu pada data terminologi EncounterStatus
 * @property \Illuminate\Support\Carbon|null $period_start Diisi dengan waktu mulai, sama dengan waktu dimulainya suatu status kunjungan dalam format YYYY-MM-DD.
 * @property \Illuminate\Support\Carbon|null $period_end Diisi dengan waktu selesai, sama dengan waktu berakhirnya suatu status kunjungan dalam format YYYY-MM-DD.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatusHistory withoutTrashed()
 */
	class EncounterStatusHistory extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string $encounter_id
 * @property string|null $transaction_id
 * @property string|null $transaction_secondary_id
 * @property string|null $description
 * @property string|null $verification_status
 * @property string|null $clinical_status
 * @property string|null $snomed_code
 * @property string|null $onset_datetime
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereOnsetDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereSnomedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereTransactionSecondaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition whereVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportCondition withoutTrashed()
 */
	class EncounterSupportCondition extends \Eloquent {}
}

namespace App\Models\Encounter{
/**
 * @property string $id
 * @property string $encounter_id
 * @property string $encounter_support_condition_id
 * @property string|null $supporting_transaction_icd10_id
 * @property string $icd10_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereEncounterSupportConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereSupportingTransactionIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterSupportConditionIcd10 withoutTrashed()
 */
	class EncounterSupportConditionIcd10 extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_encounter_id
 * @property string|null $one_health_practitioner_id id lokal untuk data practitiont
 * @property string $type_coding_system
 * @property string|null $type_coding_code
 * @property string|null $type_coding_display
 * @property string $individual_reference
 * @property string|null $individual_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitioner
 * @property-read \App\Models\Master\CodeSystem\Encounter\MasterEncounterParticipationType|null $typeCodingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereIndividualDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereIndividualReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereOneHealthPractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereTypeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereTypeCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEnconterParticipant withoutTrashed()
 */
	class OneHealthEnconterParticipant extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $encounter_id
 * @property string|null $id_encounter id yang di peroleh dari satu sehat
 * @property string|null $one_health_organization_id id lokal untuk data organization
 * @property string|null $one_health_patient_id id lokal untuk data patient
 * @property \App\Models\Master\CodeSystem\Encounter\MasterEncounterStatus|null $status Berisi data status tahapan dari pertemuan pasien dengan tipe data code, yang nilainya mengacu pada data terminologi EncounterStatus
 * @property string $class_system Berisi data klasifikasi dari pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ActEncounterCode.
 * @property string $class_code Berisi data klasifikasi dari pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ActEncounterCode.
 * @property string $class_display Berisi data klasifikasi dari pertemuan pasien dengan tipe data Coding, yang nilainya mengacu pada salah satu data terminologi dengan nama ActEncounterCode.
 * @property string $subject_reference Berisi data subjek dari pertemuan pasien dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient
 * @property string $subject_display Berisi data subjek dari pertemuan pasien dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient
 * @property \Illuminate\Support\Carbon|null $period_start Diisi dengan waktu mulai, sama dengan waktu kedatangan pasien dengan tipe data dateTime
 * @property \Illuminate\Support\Carbon|null $period_end Diisi dengan waktu mulai, sama dengan waktu kepulangan pasien dengan tipe data dateTime
 * @property string $service_provider_reference berisi data organisasi pengelola lokasi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization. (id lokal one_health_organization_id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthCondition> $OHConditions
 * @property-read int|null $o_h_conditions_count
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounterHospitalDischarge|null $OHEncounterHospitalDischarge
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounterIdentifier|null $OHEncounterIdentifier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEncounterLocation> $OHEncounterLocations
 * @property-read int|null $o_h_encounter_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEnconterParticipant> $OHEncounterParticipants
 * @property-read int|null $o_h_encounter_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReqs
 * @property-read int|null $o_h_medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservation> $OHObservation
 * @property-read int|null $o_h_observation_count
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \App\Models\Master\CodeSystem\Encounter\MasterEncounterActCode|null $classCode
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereClassCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereClassDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereClassSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereIdEncounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter wherePeriodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter wherePeriodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereServiceProviderReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereSubjectDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereSubjectReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounter withoutTrashed()
 */
	class OneHealthEncounter extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string $one_health_encounter_id
 * @property string|null $encounter_condition_id
 * @property string $code
 * @property string $display
 * @property string|null $system
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereEncounterConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCategory withoutTrashed()
 */
	class OneHealthEncounterCategory extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string $one_health_encounter_id
 * @property string|null $encounter_condition_id
 * @property string $code
 * @property string $display
 * @property string|null $system
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereEncounterConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterClinicalStatus withoutTrashed()
 */
	class OneHealthEncounterClinicalStatus extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string $one_health_encounter_id
 * @property string|null $encounter_condition_id
 * @property string|null $encounter_condition_icd_10_id
 * @property string $code
 * @property string $display
 * @property string|null $system
 * @property string $type
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereEncounterConditionIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereEncounterConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterCode withoutTrashed()
 */
	class OneHealthEncounterCode extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_encounter_id
 * @property string $coding_system
 * @property string $coding_code
 * @property string $coding_display
 * @property string|null $text
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterHospitalDischarge withoutTrashed()
 */
	class OneHealthEncounterHospitalDischarge extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_encounter_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $system Di mana isi dari parameter {patient-ihs-number} adalah ID Patient yang didapatkan dari master pasien indeks.
 * @property string $value Berisi kode atau nomor pasien. (value of one_health_encounter.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterIdentifier withoutTrashed()
 */
	class OneHealthEncounterIdentifier extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_encounter_id
 * @property string|null $one_health_location_id
 * @property string $location_reference Berisi data lokasi dari pertemuan pasien. Dapat diisi oleh ruangan periksa pasien / poli pemeriksaannya dengan tipe data Reference
 * @property string|null $location_display Berisi data lokasi dari pertemuan pasien. Dapat diisi oleh ruangan periksa pasien / poli pemeriksaannya dengan tipe data Reference
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereLocationDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereLocationReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereOneHealthLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterLocation withoutTrashed()
 */
	class OneHealthEncounterLocation extends \Eloquent {}
}

namespace App\Models\Encounter\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_encounter_id
 * @property string|null $encounter_condition_id
 * @property string|null $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereEncounterConditionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthEncounterNote withoutTrashed()
 */
	class OneHealthEncounterNote extends \Eloquent {}
}

namespace App\Models\Family{
/**
 * @property string $id
 * @property string|null $name
 * @property string|null $head_user_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $headUser
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Family\FamilyMember> $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereHeadUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Family withoutTrashed()
 */
	class Family extends \Eloquent {}
}

namespace App\Models\Family{
/**
 * @property string $id
 * @property string $family_id
 * @property string $user_id
 * @property string $relationship kepala_keluarga, istri, anak, ayah, ibu, kakek, nenek, lainnya
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Family\Family|null $family
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FamilyMember withoutTrashed()
 */
	class FamilyMember extends \Eloquent {}
}

namespace App\Models\Finance{
/**
 * @property string $id
 * @property string $code
 * @property string|null $transaction_id
 * @property string|null $purchase_order_id
 * @property string|null $stock_opname_id
 * @property string $type
 * @property string|null $description
 * @property string|null $date
 * @property numeric $sub_total
 * @property numeric $discount
 * @property numeric $tax
 * @property numeric $single_payment_admin_fee
 * @property numeric $first_service_price
 * @property numeric $second_service_price
 * @property numeric $embalage
 * @property numeric $rounding
 * @property numeric $grand_total
 * @property numeric $payment_change
 * @property numeric $total_loss_value
 * @property numeric $total_excess_value
 * @property string $status
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\FinanceItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Finance\FinancePayment|null $paymentFirst
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Finance\FinancePayment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereEmbalage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereFirstServicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance wherePaymentChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereRounding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereSecondServicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereSinglePaymentAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereStockOpnameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereTotalExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereTotalLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Finance withoutTrashed()
 */
	class Finance extends \Eloquent {}
}

namespace App\Models\Finance{
/**
 * @property string $id
 * @property string|null $finance_id
 * @property string|null $finance_recipe_id
 * @property string|null $transaction_recipe_id
 * @property string|null $transaction_detail_id
 * @property string|null $purchase_order_item_id
 * @property string|null $dead_stock_id
 * @property string|null $stock_opname_item_id
 * @property string|null $import_stock_id
 * @property string|null $account_id
 * @property string|null $product_id
 * @property string|null $description
 * @property numeric $quantity
 * @property numeric $price
 * @property numeric $price_hpp
 * @property numeric $tax
 * @property numeric $discount
 * @property numeric $sub_total
 * @property numeric $sub_total_hpp
 * @property numeric $sub_total_ppn
 * @property numeric $sub_total_dpp
 * @property numeric $loss_value
 * @property numeric $excess_value
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Finance\Finance|null $finance
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\StockOpname\StockOpnameItem|null $stockOpnameItem
 * @property-read \App\Models\Transaction\TransactionDetail|null $transactionDetail
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereDeadStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereFinanceRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereImportStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem wherePurchaseOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereStockOpnameItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereSubTotalDpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereSubTotalHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereSubTotalPpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceItem withoutTrashed()
 */
	class FinanceItem extends \Eloquent {}
}

namespace App\Models\Finance{
/**
 * @property string $id
 * @property string $finance_id
 * @property string $name
 * @property string|null $account_id
 * @property string|null $description
 * @property numeric $amount
 * @property string $type
 * @property string $type_finance
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereTypeFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceOther withoutTrashed()
 */
	class FinanceOther extends \Eloquent {}
}

namespace App\Models\Finance{
/**
 * @property string $id
 * @property string $finance_id
 * @property string|null $transaction_payment_id
 * @property string|null $account_payment_id
 * @property string|null $account_debt_id
 * @property numeric $amount
 * @property numeric $payment_real
 * @property numeric $total_loss_value
 * @property numeric $total_excess_value
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account\Account|null $accountDebt
 * @property-read \App\Models\Account\Account|null $accountPayment
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Finance\Finance|null $finance
 * @property-read \App\Models\PaymentMethod\PaymentMethod|null $paymentMethod
 * @property-read \App\Models\Transaction\TransactionPayment|null $transactionPayment
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereAccountDebtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereAccountPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment wherePaymentReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereTotalExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereTotalLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereTransactionPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinancePayment withoutTrashed()
 */
	class FinancePayment extends \Eloquent {}
}

namespace App\Models\Finance{
/**
 * @property string $id
 * @property string|null $finance_id
 * @property string|null $transaction_recipe_id
 * @property string|null $product_id
 * @property string|null $medicine_type_id
 * @property numeric $price_service_one
 * @property string|null $product_name
 * @property numeric $numero_recipe
 * @property numeric $quantity
 * @property numeric $price
 * @property numeric $price_hpp
 * @property numeric $sub_total_price
 * @property numeric $sub_total_price_hpp
 * @property numeric $sub_total_price_ppn
 * @property numeric $sub_total_price_dpp
 * @property string|null $description
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Finance\Finance|null $finance
 * @property-read \App\Models\MedicineType\MedicineType|null $medicineType
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Transaction\TransactionRecipe|null $transactionRecipe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereMedicineTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereNumeroRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe wherePriceServiceOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereSubTotalPriceDpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereSubTotalPriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereSubTotalPricePpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FinanceRecipe withoutTrashed()
 */
	class FinanceRecipe extends \Eloquent {}
}

namespace App\Models\HowToUse{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property int $day
 * @property int $time
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read string $name_display
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HowToUse withoutTrashed()
 */
	class HowToUse extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property numeric $basic_salary
 * @property string $payment_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Hr\EmployeePayrollComponent> $components
 * @property-read int|null $components_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayroll withoutTrashed()
 */
	class EmployeePayroll extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $employee_payroll_id
 * @property string $payroll_component_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Hr\PayrollComponent|null $component
 * @property-read \App\Models\Hr\EmployeePayroll|null $employeePayroll
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereEmployeePayrollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent wherePayrollComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmployeePayrollComponent withoutTrashed()
 */
	class EmployeePayrollComponent extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property string $period
 * @property numeric $basic_salary
 * @property numeric $total_allowance
 * @property numeric $total_deduction
 * @property numeric $net_salary
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Hr\PayrollDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereBasicSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereNetSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereTotalAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereTotalDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payroll withoutTrashed()
 */
	class Payroll extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property string $period
 * @property string $name
 * @property string $type
 * @property numeric $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollAdjustment withoutTrashed()
 */
	class PayrollAdjustment extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $company_id
 * @property string $name
 * @property string $type
 * @property bool $is_taxable
 * @property bool $is_active
 * @property numeric $default_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereDefaultAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereIsTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollComponent withoutTrashed()
 */
	class PayrollComponent extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string $payroll_id
 * @property string $name
 * @property string $type
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hr\Payroll|null $payroll
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail wherePayrollId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PayrollDetail whereUpdatedAt($value)
 */
	class PayrollDetail extends \Eloquent {}
}

namespace App\Models\Hr{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withoutTrashed()
 */
	class Shift extends \Eloquent {}
}

namespace App\Models\Icd{
/**
 * @property string $id
 * @property string $code
 * @property string|null $display
 * @property string $version
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionCode> $OHConditionCode
 * @property-read int|null $o_h_condition_code_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestReasonCode> $OHMedicationReqReasonCode
 * @property-read int|null $o_h_medication_req_reason_code_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd10 withoutTrashed()
 */
	class Icd10 extends \Eloquent {}
}

namespace App\Models\Icd{
/**
 * @property string $id
 * @property string $code
 * @property string|null $display
 * @property string $version
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Icd9 withoutTrashed()
 */
	class Icd9 extends \Eloquent {}
}

namespace App\Models\Insurance{
/**
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string|null $phone
 * @property string|null $description
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insurance withoutTrashed()
 */
	class Insurance extends \Eloquent {}
}

namespace App\Models\Journal{
/**
 * @property string $id
 * @property string $finance_id
 * @property string $code
 * @property string $date
 * @property string|null $description
 * @property string $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $journal_type
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Journal\JournalItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal adjustment()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal general()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal system()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereJournalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Journal withoutTrashed()
 */
	class Journal extends \Eloquent {}
}

namespace App\Models\Journal{
/**
 * @property string $id
 * @property string $journal_id
 * @property string $finance_id
 * @property string|null $finance_item_id
 * @property string|null $finance_other_id
 * @property string|null $finance_recipe_id
 * @property string|null $finance_payment_id
 * @property string|null $account_id
 * @property string|null $company_id
 * @property string|null $code
 * @property string $type
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account\Account|null $account
 * @property-read \App\Models\Account\AccountTransaction|null $accountTransaction
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Journal\Journal|null $journal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereFinanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereFinanceItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereFinanceOtherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereFinancePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereFinanceRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereJournalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JournalItem withoutTrashed()
 */
	class JournalItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $user_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $reason
 * @property string|null $attachment_path
 * @property string $status
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereAttachmentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Leave withoutTrashed()
 */
	class Leave extends \Eloquent {}
}

namespace App\Models\Location{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $location_id
 * @property \App\Models\Master\CodeSystem\Location\MasterLocationStatus|null $status Berisi data status lokasi dengan tipe data code, yang nilainya mengacu pada data terminologi LocationStatus.
 * @property string $name Berisi data nama lokasi dengan tipe data string.
 * @property string $description Berisi data deskripsi lokasi dengan tipe data string.
 * @property \App\Models\Master\CodeSystem\Location\MasterLocationMode|null $mode Berisi data mode lokasi dengan tipe data code, yang nilainya mengacu pada data terminologi LocationMode.
 * @property string $physical_type Berisi satu atau lebih daftar data mengenai informasi terkait tipe fisik lokasi dengan tipe data Coding.
 * @property string $slug
 * @property string|null $image
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\Encounter> $encounters
 * @property-read int|null $encounters_count
 * @property-read Location|null $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \App\Models\Master\CodeSystem\Location\MasterLocationType|null $physicalType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location wherePhysicalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location withoutTrashed()
 */
	class Location extends \Eloquent {}
}

namespace App\Models\Location\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_organization_id
 * @property string|null $location_id
 * @property string|null $id_location ID location dari satu sehat
 * @property \App\Models\Master\CodeSystem\Location\MasterLocationStatus|null $status Berisi data status lokasi dengan tipe data code, yang nilainya mengacu pada data terminologi LocationStatus.
 * @property string $name Berisi data nama lokasi dengan tipe data string.
 * @property string $description Berisi data deskripsi lokasi dengan tipe data string.
 * @property \App\Models\Master\CodeSystem\Location\MasterLocationMode|null $mode Berisi data mode lokasi dengan tipe data code, yang nilainya mengacu pada data terminologi LocationMode.
 * @property string $physicalType_coding_system Berisi satu atau lebih daftar data mengenai informasi terkait tipe fisik lokasi dengan tipe data Coding.
 * @property string $physicalType_coding_code Berisi satu atau lebih daftar data mengenai informasi terkait tipe fisik lokasi dengan tipe data Coding.
 * @property string $physicalType_coding_display Berisi satu atau lebih daftar data mengenai informasi terkait tipe fisik lokasi dengan tipe data Coding.
 * @property string $position_longitude Berisi data informasi mengenai garis bujur dengan tipe data decimal.
 * @property string $position_latitude Berisi data informasi mengenai garis lintang dengan tipe data decimal.
 * @property string $position_altitude Berisi data informasi mengenai ketinggian dengan tipe data decimal.
 * @property string|null $managing_organization_reference Berisi data organisasi pengelola lokasi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization.
 * @property string|null $part_of_reference Berisi data lokasi bagian dari lokasi lain (sub lokasi) dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Location
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEncounterLocation> $OHEncounterLocations
 * @property-read int|null $o_h_encounter_locations_count
 * @property-read \App\Models\Location\OneHealth\OneHealthLocationIdentifier|null $OHLIdentifier
 * @property-read \App\Models\Location\OneHealth\OneHealthLocationAddress|null $OHLocationAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocationTelecom> $OHLocationTelecoms
 * @property-read int|null $o_h_location_telecoms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \App\Models\Master\CodeSystem\Location\MasterLocationType|null $physicalType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereIdLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereManagingOrganizationReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePartOfReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePhysicalTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePhysicalTypeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePhysicalTypeCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePositionAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePositionLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation wherePositionLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocation withoutTrashed()
 */
	class OneHealthLocation extends \Eloquent {}
}

namespace App\Models\Location\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_location_id
 * @property \App\Models\Master\CodeSystem\Location\MasterLocationAddressUse|null $use Berisi data penggunaan alamat organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi AddressUse.
 * @property string $line Berisi satu atau lebih data nama, blok, no jalan atau no rumah dengan tipe data string.
 * @property string $city Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.
 * @property string|null $postal_code Berisi data kode pos dengan tipe data string.
 * @property string $country Berisi data kode negara berdasarkan ISO 3316 2-letter (contoh: ID) dengan dengan tipe data string.
 * @property string $extention_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocationAddressExtention> $extentions
 * @property-read int|null $extentions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereExtentionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereOneHealthLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddress withoutTrashed()
 */
	class OneHealthLocationAddress extends \Eloquent {}
}

namespace App\Models\Location\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_location_address_id
 * @property string $url Source of the definition for the extension code - a logical name or a URL. value : province/city/district/village
 * @property string $value_code value of master data region
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereOneHealthLocationAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention whereValueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationAddressExtention withoutTrashed()
 */
	class OneHealthLocationAddressExtention extends \Eloquent {}
}

namespace App\Models\Location\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_location_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $system Di mana isi dari parameter {organization-ihs-number} adalah ID organisasi induk yang didapatkan dari master sarana indeks.
 * @property string $value BerIsi kode atau nomor internal lokasi. (value of one_health_location.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereOneHealthLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationIdentifier withoutTrashed()
 */
	class OneHealthLocationIdentifier extends \Eloquent {}
}

namespace App\Models\Location\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_location_id
 * @property string $system Berisi data jenis kontak dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointSystem.
 * @property string $value Berisi data nomor/email/website kontak organisasi dengan tipe data string.
 * @property string $use Berisi data penggunaan kontak organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointUse.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereOneHealthLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthLocationTelecom withoutTrashed()
 */
	class OneHealthLocationTelecom extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionBodySite withoutTrashed()
 */
	class MasterConditionBodySite extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionCategory> $OHConditionCategory
 * @property-read int|null $o_h_condition_category_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCategory withoutTrashed()
 */
	class MasterConditionCategory extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string|null $master_condition_clinical_status_id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionClinicalStatus> $OHMedicationClinicalStatus
 * @property-read int|null $o_h_medication_clinical_status_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereMasterConditionClinicalStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionClinicalStatus withoutTrashed()
 */
	class MasterConditionClinicalStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionCode> $OHConditionCode
 * @property-read int|null $o_h_condition_code_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodeChiefComplaint withoutTrashed()
 */
	class MasterConditionCodeChiefComplaint extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthConditionCode> $OHConditionCode
 * @property-read int|null $o_h_condition_code_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionCodePreviousCondition withoutTrashed()
 */
	class MasterConditionCodePreviousCondition extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionSeverity withoutTrashed()
 */
	class MasterConditionSeverity extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Condition{
/**
 * @property string $id
 * @property string|null $master_condition_verification_status_id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereMasterConditionVerificationStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConditionVerificationStatus withoutTrashed()
 */
	class MasterConditionVerificationStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Consultation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string $code_system HL7 Condition Category Code System
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereCodeSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationCategoryCondition withoutTrashed()
 */
	class MasterConsultationCategoryCondition extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Consultation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string $code_system HL7 Condition Clinical Code System
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereCodeSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionClinical withoutTrashed()
 */
	class MasterConsultationConditionClinical extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Consultation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string $code_system HL7 Condition Verification Status Code System
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereCodeSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationConditionVerStatus withoutTrashed()
 */
	class MasterConsultationConditionVerStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Consultation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string $code_system Snomed CT Code System
 * @property string|null $keterangan
 * @property string $type Type of Snomed CT, e.g., keluhan utama or riwayat penyakit
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereCodeSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationSnomedCT withoutTrashed()
 */
	class MasterConsultationSnomedCT extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Consultation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string $code_system Terminology Code System
 * @property string|null $keterangan
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereCodeSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterConsultationTerminology withoutTrashed()
 */
	class MasterConsultationTerminology extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string|null $code
 * @property string|null $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActCode withoutTrashed()
 */
	class ActCode extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActPriority withoutTrashed()
 */
	class ActPriority extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterStatus withoutTrashed()
 */
	class EncounterStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncounterType withoutTrashed()
 */
	class EncounterType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string|null $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\EncounterClassHistory> $classHistories
 * @property-read int|null $class_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\Encounter> $encounters
 * @property-read int|null $encounters_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActCode withoutTrashed()
 */
	class MasterEncounterActCode extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterActPriority withoutTrashed()
 */
	class MasterEncounterActPriority extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterDiagnosisRole withoutTrashed()
 */
	class MasterEncounterDiagnosisRole extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterIdentifierUse withoutTrashed()
 */
	class MasterEncounterIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEnconterParticipant> $OHEncounterParticipants
 * @property-read int|null $o_h_encounter_participants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterParticipationType withoutTrashed()
 */
	class MasterEncounterParticipationType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterServiceType withoutTrashed()
 */
	class MasterEncounterServiceType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEncounter> $OHEncounters
 * @property-read int|null $o_h_encounters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\EncounterStatusHistory> $encounterStatusHistories
 * @property-read int|null $encounter_status_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\Encounter> $encounters
 * @property-read int|null $encounters_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterStatus withoutTrashed()
 */
	class MasterEncounterStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterEncounterType withoutTrashed()
 */
	class MasterEncounterType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParticipationType withoutTrashed()
 */
	class ParticipationType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Encounter{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceType withoutTrashed()
 */
	class ServiceType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocationAddress> $OHLocationAddresses
 * @property-read int|null $o_h_location_addresses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationAddressUse withoutTrashed()
 */
	class MasterLocationAddressUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointSystem withoutTrashed()
 */
	class MasterLocationContactPointSystem extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationContactPointUse withoutTrashed()
 */
	class MasterLocationContactPointUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationIdentifierUse withoutTrashed()
 */
	class MasterLocationIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocation> $OHLocations
 * @property-read int|null $o_h_locations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationMode withoutTrashed()
 */
	class MasterLocationMode extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocation> $OHLocations
 * @property-read int|null $o_h_locations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationStatus withoutTrashed()
 */
	class MasterLocationStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Location{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location\OneHealth\OneHealthLocation> $OHLocations
 * @property-read int|null $o_h_locations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterLocationType withoutTrashed()
 */
	class MasterLocationType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenseCategory
 * @property-read int|null $o_h_medication_dispense_category_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseCategory withoutTrashed()
 */
	class MasterMedicationDispenseCategory extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispense
 * @property-read int|null $o_h_medication_dispense_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDaysSupply withoutTrashed()
 */
	class MasterMedicationDispenseDaysSupply extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseDosageInstruction> $OHMedicationDispenseDosageInstructions
 * @property-read int|null $o_h_medication_dispense_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosageDoseRate withoutTrashed()
 */
	class MasterMedicationDispenseDosageDoseRate extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseDosagePeriodUnit withoutTrashed()
 */
	class MasterMedicationDispenseDosagePeriodUnit extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseIdentifier> $OHMedicationDispenseIdentifiers
 * @property-read int|null $o_h_medication_dispense_identifiers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseIdentifierUse withoutTrashed()
 */
	class MasterMedicationDispenseIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseOrderableDrugForm withoutTrashed()
 */
	class MasterMedicationDispenseOrderableDrugForm extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseStatus withoutTrashed()
 */
	class MasterMedicationDispenseStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationDispanse{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationDispenseValueQuantity withoutTrashed()
 */
	class MasterMedicationDispenseValueQuantity extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCategory withoutTrashed()
 */
	class MasterMedicationRequestCategory extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestCourseOfTherapy withoutTrashed()
 */
	class MasterMedicationRequestCourseOfTherapy extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest> $OHMedicationRequestDispenceRequest
 * @property-read int|null $o_h_medication_request_dispence_request_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseExpect withoutTrashed()
 */
	class MasterMedicationRequestDispenseExpect extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest> $OHedicationReqDispanseRequest
 * @property-read int|null $o_hedication_req_dispanse_request_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDispenseRequest> $medicationReqDispenseRequest
 * @property-read int|null $medication_req_dispense_request_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDispenseInterval withoutTrashed()
 */
	class MasterMedicationRequestDispenseInterval extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDosageInstruction> $OHMedicationReqDosageInstructions
 * @property-read int|null $o_h_medication_req_dosage_instructions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $medicationReqDosageInstructions
 * @property-read int|null $medication_req_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDoseRate withoutTrashed()
 */
	class MasterMedicationRequestDosageDoseRate extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageDurationUnit withoutTrashed()
 */
	class MasterMedicationRequestDosageDurationUnit extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $medicationReqDosageInstructions
 * @property-read int|null $medication_req_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosagePeriodUnit withoutTrashed()
 */
	class MasterMedicationRequestDosagePeriodUnit extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDosageInstruction> $OHMedicationReqDosageInstructions
 * @property-read int|null $o_h_medication_req_dosage_instructions_count
 * @property-read string $code_display
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $medicationReqDosageInstructions
 * @property-read int|null $medication_req_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestDosageRoute withoutTrashed()
 */
	class MasterMedicationRequestDosageRoute extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIdentifierUse withoutTrashed()
 */
	class MasterMedicationRequestIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReqs
 * @property-read int|null $o_h_medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestIntent withoutTrashed()
 */
	class MasterMedicationRequestIntent extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $code_display
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $medicationReqDosageInstructions
 * @property-read int|null $medication_req_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestOrderableDrugForm withoutTrashed()
 */
	class MasterMedicationRequestOrderableDrugForm extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReq
 * @property-read int|null $o_h_medication_req_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReq
 * @property-read int|null $medication_req_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestPriority withoutTrashed()
 */
	class MasterMedicationRequestPriority extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReq
 * @property-read int|null $o_h_medication_req_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReq
 * @property-read int|null $medication_req_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestStatus withoutTrashed()
 */
	class MasterMedicationRequestStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\MedicationRequest{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $code_display
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $medicationReqDosageInstructions
 * @property-read int|null $medication_req_dosage_instructions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationRequestValueQuantity withoutTrashed()
 */
	class MasterMedicationRequestValueQuantity extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $code_display
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\Medication> $medications
 * @property-read int|null $medications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationForm withoutTrashed()
 */
	class MasterMedicationForm extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationIdentifierUse withoutTrashed()
 */
	class MasterMedicationIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationOrderableDrugForm withoutTrashed()
 */
	class MasterMedicationOrderableDrugForm extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\OneHealth\OneHealthMedication> $OHMedication
 * @property-read int|null $o_h_medication_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\Medication> $medication
 * @property-read int|null $medication_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationStatus withoutTrashed()
 */
	class MasterMedicationStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\Medication> $medications
 * @property-read int|null $medications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationType withoutTrashed()
 */
	class MasterMedicationType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Medication{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterMedicationValueQuantity withoutTrashed()
 */
	class MasterMedicationValueQuantity extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Observation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservationCategory> $OHObservationCategories
 * @property-read int|null $o_h_observation_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCategory withoutTrashed()
 */
	class MasterObservationCategory extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Observation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservationCode> $OHObservationCodes
 * @property-read int|null $o_h_observation_codes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationCode withoutTrashed()
 */
	class MasterObservationCode extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Observation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationStatus withoutTrashed()
 */
	class MasterObservationStatus extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Observation{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservationValueQuantity> $OHObservationValueQuantities
 * @property-read int|null $o_h_observation_value_quantities_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterObservationValueQuantity withoutTrashed()
 */
	class MasterObservationValueQuantity extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressType withoutTrashed()
 */
	class MasterOrganizationAddressType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationAddressUse withoutTrashed()
 */
	class MasterOrganizationAddressUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointSystem withoutTrashed()
 */
	class MasterOrganizationContactPointSystem extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MasterOrganizationContactPointUse> $use
 * @property-read int|null $use_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationContactPointUse withoutTrashed()
 */
	class MasterOrganizationContactPointUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\OneHealth\OneHealthOrganizationIdentifier> $OHOrganizationIdentifier
 * @property-read int|null $o_h_organization_identifier_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationIndentifierUse withoutTrashed()
 */
	class MasterOrganizationIndentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Organization{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\OneHealth\OneHealthOrganization> $OHOrganization
 * @property-read int|null $o_h_organization_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterOrganizationType withoutTrashed()
 */
	class MasterOrganizationType extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAddressUse withoutTrashed()
 */
	class MasterPatientAddressUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\OneHealth\OneHealthPatient> $OHPatient
 * @property-read int|null $o_h_patient_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\Patient> $patient
 * @property-read int|null $patient_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientAdministrativeGender withoutTrashed()
 */
	class MasterPatientAdministrativeGender extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointSystem withoutTrashed()
 */
	class MasterPatientContactPointSystem extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactPointUse withoutTrashed()
 */
	class MasterPatientContactPointUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\PatientContactRelationship> $patientContactRelationships
 * @property-read int|null $patient_contact_relationships_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientContactRelationship withoutTrashed()
 */
	class MasterPatientContactRelationship extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientIdentifierUse withoutTrashed()
 */
	class MasterPatientIdentifierUse extends \Eloquent {}
}

namespace App\Models\Master\CodeSystem\Patient{
/**
 * @property string $id
 * @property string $code
 * @property string $display
 * @property string|null $definition
 * @property string|null $comments
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\OneHealth\OneHealthPatient> $OHPatient
 * @property-read int|null $o_h_patient_count
 * @property-read mixed $display_ind
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\Patient> $patient
 * @property-read int|null $patient_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereDefinition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPatientMaritalStatus withoutTrashed()
 */
	class MasterPatientMaritalStatus extends \Eloquent {}
}

namespace App\Models\Master\Region{
/**
 * @property string $id
 * @property string $code
 * @property string|null $parent_code
 * @property string|null $bps_code
 * @property string $name
 * @property int $order
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Master\Region\District> $districts
 * @property-read int|null $districts_count
 * @property-read \App\Models\Master\Region\Province|null $province
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereBpsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereParentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models\Master\Region{
/**
 * @property string $id
 * @property string $code
 * @property string|null $parent_code
 * @property string|null $bps_code
 * @property string $name
 * @property int $order
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Master\Region\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Master\Region\SubDistrict> $subDistricts
 * @property-read int|null $sub_districts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereBpsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereParentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|District whereUpdatedAt($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models\Master\Region{
/**
 * @property string $id
 * @property string $code
 * @property string|null $parent_code
 * @property string|null $bps_code
 * @property string $name
 * @property int $order
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Master\Region\City> $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereBpsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereParentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereUpdatedAt($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Models\Master\Region{
/**
 * @property string $id
 * @property string $code
 * @property string|null $parent_code
 * @property string|null $bps_code
 * @property string $name
 * @property int $order
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Master\Region\District|null $district
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereBpsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereParentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubDistrict whereUpdatedAt($value)
 */
	class SubDistrict extends \Eloquent {}
}

namespace App\Models\MedicationDispense{
/**
 * @property string $id
 * @property string|null $transaction_detail_id
 * @property string|null $company_id
 * @property string|null $location_id
 * @property string|null $practitioner_id
 * @property string|null $patient_id
 * @property string|null $encounter_id
 * @property string|null $medication_id
 * @property string|null $medication_request_id
 * @property string|null $performerable_type
 * @property string|null $performerable_id
 * @property \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseStatus|null $status Berisi data yang berkaitan dengan kode spesifik yang menunjukkan status pengobatan saat ini yang umumnya akan berupa status aktif atau komplit dengan tipe data code yang nilainya mengacu pada MedicationDispense Status.
 * @property string $category Berisi satu atau lebih data yang berkaitan dengan tipe permintaan pengobatan, seperti pengobatan yang diberikan/dikonsumsi pada rawat inap atau rawat jalan dengan tipe data Coding, yang nilainya mengacu pada MedicationDispense category.
 * @property int $quantity_value Berisi data jumlah obat yang dikeluarkan dalam bentuk numerical dengan tipe data SimpleQuantity, yang nilai satuan kekuatan zat aktif dapat mengacu pada data terminologi OrderableDrugForm (http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm) dan SNOMED CT.
 * @property string $quantity_code Berisi data jumlah obat yang dikeluarkan dalam bentuk numerical dengan tipe data SimpleQuantity, yang nilai satuan kekuatan zat aktif dapat mengacu pada data terminologi OrderableDrugForm (http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm) dan SNOMED CT.
 * @property int $day_value Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property string $day_code Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property \Illuminate\Support\Carbon $when_prepare Berisi data yang berkaitan dengan kapan obat dikemas dan dicek
 * @property \Illuminate\Support\Carbon $when_hand_over Berisi data yang berisikan data waktu pemberian obat kepada pasien atau penanggungjawab pasien
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense|null $OHMedicationDispense
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispenseDosageInstruction> $dispenseDosageInstructions
 * @property-read int|null $dispense_dosage_instructions_count
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \App\Models\Medication\Medication|null $medication
 * @property-read \App\Models\MedicationRequest\MedicationRequest|null $medicationReq
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $performerable
 * @property-read \App\Models\Practitiont\Practitioner|null $practitioner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereDayCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereDayValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense wherePerformerableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense wherePerformerableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereWhenHandOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense whereWhenPrepare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispense withoutTrashed()
 */
	class MedicationDispense extends \Eloquent {}
}

namespace App\Models\MedicationDispense{
/**
 * @property string $id
 * @property string|null $medication_dispense_id
 * @property int $sequence Berisi data paket aturan pakai dengan nilai sequence dengan tipe data integer.
 * @property string $text Berisi satu atau lebih data aturan pakai obat dalam bentuk naratif dengan tipe data string.
 * @property int $timing_repeat_frequency Berisi data frekuensi pengulangan dalam jangka waktu (period) tertentu
 * @property int $timing_repeat_period Berisi data jangka waktu/durasi waktu di mana repetisi akan terjadi
 * @property string $timing_repeat_period_unit Berisi data unit dari period dalam UCUM (http://unitsofmeasure.org)
 * @property string $dose_rate_type_coding_code Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property int $dose_rate_quantity_value Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_code Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MedicationDispenseDosageInstruction|null $medicationDispense
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereDoseRateQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereDoseRateQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereDoseRateTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereTimingRepeatFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereTimingRepeatPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereTimingRepeatPeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationDispenseDosageInstruction withoutTrashed()
 */
	class MedicationDispenseDosageInstruction extends \Eloquent {}
}

namespace App\Models\MedicationDispense\OneHealth{
/**
 * @property string $id
 * @property string|null $medication_dispense_id
 * @property string|null $id_medication_dispense
 * @property string|null $one_health_organization_id
 * @property string|null $one_health_location_id
 * @property string|null $one_health_patient_id
 * @property string|null $one_health_practitioner_id
 * @property string|null $one_health_encounter_id
 * @property string|null $one_health_medication_id
 * @property string|null $one_health_medication_request_id
 * @property \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseStatus|null $status Berisi data yang berkaitan dengan kode spesifik yang menunjukkan status pengobatan saat ini yang umumnya akan berupa status aktif atau komplit dengan tipe data code yang nilainya mengacu pada MedicationDispense Status.
 * @property string $medication_reference Berisi data informasi obat yang diresepkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Medication
 * @property string $medication_display Berisi data informasi obat yang diresepkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Medication
 * @property string $subject_reference Berisi data informasi pasien yang diresepkan obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $subject_display Berisi data informasi pasien yang diresepkan obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $context_reference Berisi data informasi terkait kunjungan di mana dispense obat dilakukan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Encounter | EpisodeOfCare
 * @property string $location_reference Berisi data lokasi di mana obat diberikan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Location.id
 * @property string $location_display Berisi data lokasi di mana obat diberikan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Location.id
 * @property string $authorizing_reference Berisi data otorisasi resep dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource MedicationRequest.id
 * @property string $quantity_system Berisi data jumlah obat yang dikeluarkan dalam bentuk numerical dengan tipe data SimpleQuantity, yang nilai satuan kekuatan zat aktif dapat mengacu pada data terminologi OrderableDrugForm (http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm) dan SNOMED CT.
 * @property string $quantity_code Berisi data jumlah obat yang dikeluarkan dalam bentuk numerical dengan tipe data SimpleQuantity, yang nilai satuan kekuatan zat aktif dapat mengacu pada data terminologi OrderableDrugForm (http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm) dan SNOMED CT.
 * @property int $quantity_value Berisi data jumlah obat yang dikeluarkan dalam bentuk numerical dengan tipe data SimpleQuantity, yang nilai satuan kekuatan zat aktif dapat mengacu pada data terminologi OrderableDrugForm (http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm) dan SNOMED CT.
 * @property int $day_value Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property string $day_unit Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property string $day_system Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property string $day_code Berisi data jumlah pengobatan yang dinyatakan dalam satuan hari dengan tipe data SimpleQuantity.
 * @property \Illuminate\Support\Carbon $when_prepare Berisi data yang berkaitan dengan kapan obat dikemas dan dicek
 * @property \Illuminate\Support\Carbon $when_hand_over Berisi data yang berisikan data waktu pemberian obat kepada pasien atau penanggungjawab pasien
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Location\OneHealth\OneHealthLocation|null $OHLocation
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseCategory|null $OHMedicationDispenseCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseIdentifier> $OHMedicationDispenseIdentifiers
 * @property-read int|null $o_h_medication_dispense_identifiers_count
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispensePerformer|null $OHMedicationDispensePerformer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispenseDosageInstruction> $OHMedicationDosageInstructions
 * @property-read int|null $o_h_medication_dosage_instructions_count
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitioner
 * @property-read \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseDaysSupply|null $daysCode
 * @property-read \App\Models\MedicationDispense\MedicationDispense|null $medicationDispense
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereAuthorizingReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereContextReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereDayCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereDaySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereDayUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereDayValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereIdMedicationDispense($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereLocationDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereLocationReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereMedicationDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereMedicationReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOneHealthPractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereSubjectDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereSubjectReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereWhenHandOver($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense whereWhenPrepare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispense withoutTrashed()
 */
	class OneHealthMedicationDispense extends \Eloquent {}
}

namespace App\Models\MedicationDispense\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_dispense_id
 * @property string $coding_system
 * @property string|null $coding_code
 * @property string|null $coding_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense|null $OHMedicationDispense
 * @property-read \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereOneHealthMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseCategory withoutTrashed()
 */
	class OneHealthMedicationDispenseCategory extends \Eloquent {}
}

namespace App\Models\MedicationDispense\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_dispense_id
 * @property int $sequence Berisi data paket aturan pakai dengan nilai sequence dengan tipe data integer.
 * @property string $text Berisi satu atau lebih data aturan pakai obat dalam bentuk naratif dengan tipe data string.
 * @property int $timing_repeat_frequency Berisi data frekuensi pengulangan dalam jangka waktu (period) tertentu
 * @property int $timing_repeat_period Berisi data jangka waktu/durasi waktu di mana repetisi akan terjadi
 * @property string $timing_repeat_period_unit Berisi data unit dari period dalam UCUM (http://unitsofmeasure.org)
 * @property string $dose_rate_type_coding_system Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property string $dose_rate_type_coding_code Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property string $dose_rate_type_coding_display Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property int $dose_rate_quantity_value Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_unit Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_system Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_code Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense|null $OHMedicationDispense
 * @property-read \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseDosageDoseRate|null $doseRateType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateQuantityUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateTypeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereDoseRateTypeCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereOneHealthMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereTimingRepeatFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereTimingRepeatPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereTimingRepeatPeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseDosageInstruction withoutTrashed()
 */
	class OneHealthMedicationDispenseDosageInstruction extends \Eloquent {}
}

namespace App\Models\MedicationDispense\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_dispense_id
 * @property string|null $one_health_organization_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $system Di mana isi dari parameter {organization-ihs-number} adalah ID organisasi induk yang didapatkan dari master sarana indeks.
 * @property string $value Berisi ID lokal obat yang disimpan di sistem internal masing-masing organisasi. (value of one_health_medication_request.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense|null $OHMedicationDispense
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Master\CodeSystem\MedicationDispanse\MasterMedicationDispenseIdentifierUse|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereOneHealthMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispenseIdentifier withoutTrashed()
 */
	class OneHealthMedicationDispenseIdentifier extends \Eloquent {}
}

namespace App\Models\MedicationDispense\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_dispense_id
 * @property string $performerable_type
 * @property string $performerable_id
 * @property string $actor_reference
 * @property string $actor_reference_id
 * @property string $actor_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense|null $OHMedicationDispense
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereActorDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereActorReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereActorReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereOneHealthMedicationDispenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer wherePerformerableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer wherePerformerableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationDispensePerformer withoutTrashed()
 */
	class OneHealthMedicationDispensePerformer extends \Eloquent {}
}

namespace App\Models\MedicationRequest{
/**
 * @property string $id
 * @property string|null $transaction_detail_id
 * @property string|null $company_id
 * @property string|null $patient_id
 * @property string|null $encounter_id
 * @property string|null $medication_id
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestStatus|null $status Berisi data berkaitan dengan kode spesifik yang menunjukkan status pengobatan saat ini yang umumnya akan berupa status aktif atau komplit dengan tipe data code, yang nilainya mengacu pada data terminologi medicationrequest Status (http://hl7.org/fhir/CodeSystem/medicationrequest-status).
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestIntent|null $intent Berisi data berkaitan dengan tujuan pengobatan yang diresepkan apakah usulan, rencana, atau rencana pengobatan asli dengan tipe data code, yang nilainya mengacu pada data terminologi medicationRequest Intent (http://hl7.org/fhir/CodeSystem/medicationrequest-intent).
 * @property string $category Berisi data berkaitan dengan tipe permintaan pengobatan, seperti pengobatan yang diberikan/dikonsumsi pada rawat inap atau rawat jalan dengan tipe data CodeableConcept, yang nilainya mengacu pada data terminologi MedicationRequest Category Codes (http://terminology.hl7.org/CodeSystem/medicationrequest-category).
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestPriority|null $priority Berisi data yang mengindikasikan seberapa cepat permintaan pengobatan sebaiknya ditangani terkait dengan permintaan lainnya dengan tipe data code, yang nilainya mengacu pada data terminologi RequestPriority (http://hl7.org/fhir/request-priority).
 * @property \Illuminate\Support\Carbon $author_on Berisi data waktu peresepan dengan tipe data dateTime
 * @property string $requestable_type
 * @property string $requestable_id
 * @property string $reason_code Berisi data mengenai alasan atau indikasi untuk meminta atau tidak meminta pengobatan dengan tipe data Coding yang nilainya mengacu pada kode ICD-10 code versi 2010.
 * @property string $course_of_therapy Berisi data yang mendeskripsikan keseluruhan pola pemberian obat pada pasien dengan tipe data Coding yang nilainya mengacu pada data terminologi MedicationRequest Course of Therapy Codes.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequestDosageInstruction> $dosageInstructions
 * @property-read int|null $dosage_instructions_count
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Medication\Medication|null $medication
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \App\Models\MedicationRequest\MedicationRequestDispenseRequest|null $medicationReqDispense
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \App\Models\Icd\Icd10|null $reasonCode
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $requestable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereAuthorOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereCourseOfTherapy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereIntent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereReasonCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereRequestableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereRequestableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequest withoutTrashed()
 */
	class MedicationRequest extends \Eloquent {}
}

namespace App\Models\MedicationRequest{
/**
 * @property string $id
 * @property string|null $medication_request_id
 * @property string|null $company_id
 * @property int $dispense_interval_value Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property string $dispense_interval_code Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property \Illuminate\Support\Carbon $validity_start Berisi data Periode waktu peresepan obat valid
 * @property \Illuminate\Support\Carbon $validity_end Berisi data Periode waktu peresepan obat valid
 * @property int $number_repeat Berisi data Periode waktu peresepan obat valid
 * @property int $quantity_value Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property string $quantity_code Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property int $expect_value Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property string $expect_code Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest|null $OHMedicationReqDispanseRequest
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\MedicationRequest\MedicationRequest|null $medicationReq
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereDispenseIntervalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereDispenseIntervalValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereExpectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereExpectValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereNumberRepeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereValidityEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest whereValidityStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDispenseRequest withoutTrashed()
 */
	class MedicationRequestDispenseRequest extends \Eloquent {}
}

namespace App\Models\MedicationRequest{
/**
 * @property string $id
 * @property string|null $medication_request_id
 * @property int $sequence Berisi data paket aturan pakai dengan nilai sequence dengan tipe data integer.
 * @property string $text Berisi satu atau lebih data aturan pakai obat dalam bentuk naratif dengan tipe data string.
 * @property string|null $additional_text Berisi data yang berkaitan dengan instruksi tambahan bagi pasien mengenai bagaimana penggunaan obat
 * @property string|null $patient_instruction Berisi data instruksi aturan pakai dengan orientasi pasien dengan tipe data string.
 * @property int $timing_repeat_frequency Berisi data frekuensi pengulangan dalam jangka waktu (period) tertentu
 * @property int $timing_repeat_period Berisi data jangka waktu/durasi waktu di mana repetisi akan terjadi
 * @property string $timing_repeat_period_unit Berisi data unit dari period dalam UCUM (http://unitsofmeasure.org)
 * @property string $route_coding_code Berisi data kode untuk aturan kapan suatu obat harus dikonsumsi
 * @property string $dose_rate_type_coding_code Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property int $dose_rate_quantity_value Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_code Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestValueQuantity|null $dosageRateQuantityValue
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestOrderableDrugForm|null $doseRateQuantityOrderable
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageDoseRate|null $doseTypeCodingCode
 * @property-read \App\Models\MedicationRequest\MedicationRequest|null $medicationReq
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageRoute|null $routeTimingCode
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosagePeriodUnit|null $timingRepeatPeriodUnit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereAdditionalText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereDoseRateQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereDoseRateQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereDoseRateTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction wherePatientInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereRouteCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereTimingRepeatFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereTimingRepeatPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereTimingRepeatPeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationRequestDosageInstruction withoutTrashed()
 */
	class MedicationRequestDosageInstruction extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $medication_request_id
 * @property string|null $one_health_organization_id
 * @property string|null $one_health_patient_id
 * @property string|null $one_health_encounter_id
 * @property string|null $one_health_medication_id
 * @property string|null $id_medication_request
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestStatus|null $status Berisi data berkaitan dengan kode spesifik yang menunjukkan status pengobatan saat ini yang umumnya akan berupa status aktif atau komplit dengan tipe data code, yang nilainya mengacu pada data terminologi medicationrequest Status (http://hl7.org/fhir/CodeSystem/medicationrequest-status).
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestIntent|null $intent Berisi data berkaitan dengan tujuan pengobatan yang diresepkan apakah usulan, rencana, atau rencana pengobatan asli dengan tipe data code, yang nilainya mengacu pada data terminologi medicationRequest Intent (http://hl7.org/fhir/CodeSystem/medicationrequest-intent).
 * @property \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestPriority|null $priority Berisi data yang mengindikasikan seberapa cepat permintaan pengobatan sebaiknya ditangani terkait dengan permintaan lainnya dengan tipe data code, yang nilainya mengacu pada data terminologi RequestPriority (http://hl7.org/fhir/request-priority).
 * @property string $medication_reference Berisi data informasi obat yang diresepkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Medication
 * @property string $medication_display Berisi data informasi obat yang diresepkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Medication
 * @property string $subject_reference Berisi data informasi pasien yang diresepkan obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $subject_display Berisi data informasi pasien yang diresepkan obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group
 * @property string $encounter_reference Berisi data informasi terkait kunjungan di mana peresepan obat dilakukan. WAJIB diisi apabila peresepan obat terjadi di rumah sakit dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Encounter.
 * @property \Illuminate\Support\Carbon $author_on Berisi data waktu peresepan dengan tipe data dateTime
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestCategory|null $OHMedicationReqCategory
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestCourseTherapy|null $OHMedicationReqCourseTherapy
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest|null $OHMedicationReqDispenseRequest
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDosageInstruction> $OHMedicationReqDosageInstructions
 * @property-read int|null $o_h_medication_req_dosage_instructions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestIdentifier> $OHMedicationReqIdentifiers
 * @property-read int|null $o_h_medication_req_identifiers_count
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestReasonCode|null $OHMedicationReqReasonCode
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestRequester|null $OHMedicationReqRequester
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \App\Models\MedicationRequest\MedicationRequest|null $medicationReq
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereAuthorOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereEncounterReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereIdMedicationRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereIntent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereMedicationDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereMedicationReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereSubjectDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereSubjectReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequest withoutTrashed()
 */
	class OneHealthMedicationRequest extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string $coding_system
 * @property string|null $coding_code
 * @property string|null $coding_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCategory withoutTrashed()
 */
	class OneHealthMedicationRequestCategory extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string $coding_system Berisi data yang mendeskripsikan keseluruhan pola pemberian obat pada pasien dengan tipe data Coding yang nilainya mengacu pada data terminologi MedicationRequest Course of Therapy Codes.
 * @property string $coding_code Berisi data yang mendeskripsikan keseluruhan pola pemberian obat pada pasien dengan tipe data Coding yang nilainya mengacu pada data terminologi MedicationRequest Course of Therapy Codes.
 * @property string $coding_display Berisi data yang mendeskripsikan keseluruhan pola pemberian obat pada pasien dengan tipe data Coding yang nilainya mengacu pada data terminologi MedicationRequest Course of Therapy Codes.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestCourseOfTherapy|null $codingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestCourseTherapy withoutTrashed()
 */
	class OneHealthMedicationRequestCourseTherapy extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string|null $one_health_organization_id
 * @property int $dispense_interval_value Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property string $dispense_interval_unit Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property string $dispense_interval_system Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property string $dispense_interval_code Berisi data yang Berkaitan dengan periode waktu minimal yang harus dilakukan antara pengeluaran obat
 * @property \Illuminate\Support\Carbon $validity_start Berisi data Periode waktu peresepan obat valid
 * @property \Illuminate\Support\Carbon $validity_end Berisi data Periode waktu peresepan obat valid
 * @property int $number_repeat Berisi data Periode waktu peresepan obat valid
 * @property int $quantity_value Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property string $quantity_unit Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property string $quantity_system Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property string $quantity_code Berisi data jumlah obat yang diberikan dalam 1 kali resep
 * @property int $expect_value Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property string $expect_unit Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property string $expect_system Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property string $expect_code Berisi data identifikasi periode waktu selama produk yang diberikan diharapkan digunakan atau lamanya waktu pengeluaran yang diharapkan
 * @property string $performer_reference Berisi data organisasi yang ditunjuk untuk melakukan dispensing obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedictionReq
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDispenseInterval|null $dispenseIntervalCode
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDispenseExpect|null $expectCode
 * @property-read \App\Models\MedicationRequest\MedicationRequestDispenseRequest|null $medicationReqDispenseRequest
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereDispenseIntervalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereDispenseIntervalSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereDispenseIntervalUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereDispenseIntervalValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereExpectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereExpectSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereExpectUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereExpectValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereNumberRepeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest wherePerformerReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereQuantityUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereValidityEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest whereValidityStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDispenseRequest withoutTrashed()
 */
	class OneHealthMedicationRequestDispenseRequest extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property int $sequence Berisi data paket aturan pakai dengan nilai sequence dengan tipe data integer.
 * @property string $text Berisi satu atau lebih data aturan pakai obat dalam bentuk naratif dengan tipe data string.
 * @property string|null $additional_text Berisi data yang berkaitan dengan instruksi tambahan bagi pasien mengenai bagaimana penggunaan obat
 * @property string|null $patient_instruction Berisi data instruksi aturan pakai dengan orientasi pasien dengan tipe data string.
 * @property int $timing_repeat_frequency Berisi data frekuensi pengulangan dalam jangka waktu (period) tertentu
 * @property int $timing_repeat_period Berisi data jangka waktu/durasi waktu di mana repetisi akan terjadi
 * @property string $timing_repeat_period_unit Berisi data unit dari period dalam UCUM (http://unitsofmeasure.org)
 * @property string $route_coding_system Berisi data kode untuk aturan kapan suatu obat harus dikonsumsi
 * @property string $route_coding_code Berisi data kode untuk aturan kapan suatu obat harus dikonsumsi
 * @property string $route_coding_display Berisi data kode untuk aturan kapan suatu obat harus dikonsumsi
 * @property string $dose_rate_type_coding_system Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property string $dose_rate_type_coding_code Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property string $dose_rate_type_coding_display Berisi data yang berkaitan dengan jenis atau laju pengobatan yang diresepkan dengan tipe data CodeableConcept yang nilainya mengacu pada data terminologi DoseAndRateType.
 * @property int $dose_rate_quantity_value Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_unit Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_system Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property string $dose_rate_quantity_code Berisi data jumlah obat yang diberikan perdosis dituliskan dalam bentuk kuantitas
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageDoseRate|null $doseRateType
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageRoute|null $routeCodingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereAdditionalText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateQuantityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateQuantityUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateQuantityValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateTypeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateTypeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereDoseRateTypeCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction wherePatientInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereRouteCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereRouteCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereRouteCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereTimingRepeatFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereTimingRepeatPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereTimingRepeatPeriodUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestDosageInstruction withoutTrashed()
 */
	class OneHealthMedicationRequestDosageInstruction extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string|null $one_health_organization_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $system Di mana isi dari parameter {organization-ihs-number} adalah ID organisasi induk yang didapatkan dari master sarana indeks.
 * @property string $value Berisi ID lokal obat yang disimpan di sistem internal masing-masing organisasi. (value of one_health_medication_request.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestIdentifier withoutTrashed()
 */
	class OneHealthMedicationRequestIdentifier extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string $coding_system Berisi data mengenai alasan atau indikasi untuk meminta atau tidak meminta pengobatan dengan tipe data Coding yang nilainya mengacu pada kode ICD-10 code versi 2010.
 * @property string $coding_code Berisi data mengenai alasan atau indikasi untuk meminta atau tidak meminta pengobatan dengan tipe data Coding yang nilainya mengacu pada kode ICD-10 code versi 2010.
 * @property string $coding_display Berisi data mengenai alasan atau indikasi untuk meminta atau tidak meminta pengobatan dengan tipe data Coding yang nilainya mengacu pada kode ICD-10 code versi 2010.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @property-read \App\Models\Icd\Icd10|null $codingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestReasonCode withoutTrashed()
 */
	class OneHealthMedicationRequestReasonCode extends \Eloquent {}
}

namespace App\Models\MedicationRequest\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_request_id
 * @property string $requestable_type
 * @property string $requestable_id
 * @property string $reference
 * @property string $reference_id
 * @property string $display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest|null $OHMedicationReq
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereOneHealthMedicationRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereRequestableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereRequestableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationRequestRequester withoutTrashed()
 */
	class OneHealthMedicationRequestRequester extends \Eloquent {}
}

namespace App\Models\Medication{
/**
 * @property string $id
 * @property string|null $product_id
 * @property string|null $company_id
 * @property string|null $code_coding_code Berisi data kode obat yang digunakan akan menggunakan kode obat yang tersedia pada KFA (kamus farmasi dan alat kesehatan) dengan tipe data CodeableConcept.
 * @property string|null $code_coding_display Berisi data kode obat yang digunakan akan menggunakan kode obat yang tersedia pada KFA (kamus farmasi dan alat kesehatan) dengan tipe data CodeableConcept.
 * @property \App\Models\Master\CodeSystem\Medication\MasterMedicationStatus|null $status Berisi data kode yang mengindikasikan pengobatan dalam penggunaan aktif dengan tipe data code, yang nilainya mengacu pada data terminologi Medication Status Codes.
 * @property string|null $manufacturer_reference Berisi data kode obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization, yang menyimpan data pabrik obat.
 * @property string|null $form_coding_code Berisi data yang menjelaskan bentuk dari sediaan obat yang merujuk pada Peraturan Kepala Badan Pengawas Obat dan Makanan Republik Indonesia Nomor 24 Tahun 2017 dengan tipe data Coding.
 * @property string|null $form_coding_display Berisi data yang menjelaskan bentuk dari sediaan obat yang merujuk pada Peraturan Kepala Badan Pengawas Obat dan Makanan Republik Indonesia Nomor 24 Tahun 2017 dengan tipe data Coding.
 * @property string $medication_type_code Berisi satu atau lebih data bertipe Extension yang digunakan menyimpan informasi apakah obat yang diresepkan atau dikeluarkan merupakan obat non-racikan, obat racikan dengan instruksi berikan dalam dosis demikian/ d.t.d, atau obat racikan non-d.t.d, yang nilai dan strukturnya mengacu pada extension tambahan dengan nama MedicationType.
 * @property string|null $medication_type_display Berisi satu atau lebih data bertipe Extension yang digunakan menyimpan informasi apakah obat yang diresepkan atau dikeluarkan merupakan obat non-racikan, obat racikan dengan instruksi berikan dalam dosis demikian/ d.t.d, atau obat racikan non-d.t.d, yang nilai dan strukturnya mengacu pada extension tambahan dengan nama MedicationType.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Master\CodeSystem\Medication\MasterMedicationForm|null $formCodingCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\MedicationIngredient> $medicationIngredients
 * @property-read int|null $medication_ingredients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @property-read \App\Models\Master\CodeSystem\Medication\MasterMedicationType|null $medicationType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereCodeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereCodeCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereFormCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereFormCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereManufacturerReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereMedicationTypeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereMedicationTypeDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medication withoutTrashed()
 */
	class Medication extends \Eloquent {}
}

namespace App\Models\Medication{
/**
 * @property string $id
 * @property string|null $medication_id
 * @property string|null $product_id
 * @property string $item_coding_code Berisi data kode zat aktif atau kode obat template dengan tipe data Coding, yang nilainya mengacu pada data terminologi [Kamus Farmasi dan Alat Kesehatan.
 * @property string|null $item_coding_display Berisi data kode zat aktif atau kode obat template dengan tipe data Coding, yang nilainya mengacu pada data terminologi [Kamus Farmasi dan Alat Kesehatan.
 * @property bool $is_active Berisi data informasi apakah komposisi obat tersebut merupakan zat aktif dengan tipe data boolean.
 * @property numeric $strength_numerator_value
 * @property string $strength_numerator_code Berisi dari data master_value_quantities
 * @property numeric $strength_denominator_value
 * @property string $strength_denominator_code Berisi dari data master_value_quantities, master_orderable_drug_forms
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedicationIngredient|null $OHMedictionIngredient
 * @property-read \App\Models\Medication\Medication|null $medication
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereItemCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereItemCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereStrengthDenominatorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereStrengthDenominatorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereStrengthNumeratorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereStrengthNumeratorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicationIngredient withoutTrashed()
 */
	class MedicationIngredient extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $medication_id
 * @property string|null $id_medication
 * @property string $meta_profile
 * @property \App\Models\Master\CodeSystem\Medication\MasterMedicationStatus|null $status Berisi data kode yang mengindikasikan pengobatan dalam penggunaan aktif dengan tipe data code, yang nilainya mengacu pada data terminologi Medication Status Codes.
 * @property string|null $manufacturer_reference Berisi data kode obat dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Organization, yang menyimpan data pabrik obat.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedicationExtension|null $OHExtension
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Medication\OneHealth\OneHealthMedicationIngredient> $OHIngredients
 * @property-read int|null $o_h_ingredients_count
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedicationCode|null $OHMedicationCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedicationForm|null $OHMedicationForm
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedicationIdentifier|null $OHMedicationIdentifier
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReqs
 * @property-read int|null $o_h_medication_reqs_count
 * @property-read \App\Models\Medication\Medication|null $medication
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereIdMedication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereManufacturerReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereMetaProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedication withoutTrashed()
 */
	class OneHealthMedication extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_id
 * @property string $coding_system
 * @property string|null $coding_code
 * @property string|null $coding_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationCode withoutTrashed()
 */
	class OneHealthMedicationCode extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_id
 * @property string $url
 * @property string $value_coding_system
 * @property string|null $value_coding_code
 * @property string|null $value_coding_display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereValueCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereValueCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension whereValueCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationExtension withoutTrashed()
 */
	class OneHealthMedicationExtension extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_id
 * @property string $system
 * @property string|null $code
 * @property string|null $display
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \App\Models\Master\CodeSystem\Medication\MasterMedicationForm|null $masterForm
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationForm withoutTrashed()
 */
	class OneHealthMedicationForm extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_id
 * @property string|null $one_health_organization_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $system Di mana isi dari parameter {organization-ihs-number} adalah ID organisasi induk yang didapatkan dari master sarana indeks.
 * @property string $value Berisi ID lokal obat yang disimpan di sistem internal masing-masing organisasi. (value of one_health_medication.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIdentifier withoutTrashed()
 */
	class OneHealthMedicationIdentifier extends \Eloquent {}
}

namespace App\Models\Medication\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_medication_id
 * @property string|null $medication_ingredient_id
 * @property string $item_coding_system
 * @property string $item_coding_code
 * @property string $item_coding_display
 * @property bool $is_active
 * @property int $strength_numerator_value
 * @property string $strength_numerator_system
 * @property string $strength_numerator_code Berisi dari data master_value_quantities
 * @property int $strength_denominator_value
 * @property string $strength_denominator_system
 * @property string $strength_denominator_code erisi dari data master_value_quantities, master_orderable_drug_forms
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Medication\OneHealth\OneHealthMedication|null $OHMedication
 * @property-read \App\Models\Medication\MedicationIngredient|null $medictionIngredient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereItemCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereItemCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereItemCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereMedicationIngredientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereOneHealthMedicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthDenominatorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthDenominatorSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthDenominatorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthNumeratorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthNumeratorSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereStrengthNumeratorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthMedicationIngredient withoutTrashed()
 */
	class OneHealthMedicationIngredient extends \Eloquent {}
}

namespace App\Models\MedicineType{
/**
 * @property string $id
 * @property string $name
 * @property numeric $service_price
 * @property numeric $price_other
 * @property bool $is_single
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereIsSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType wherePriceOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereServicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicineType withoutTrashed()
 */
	class MedicineType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_read
 * @property string|null $user_id
 * @property string|null $users
 * @property string|null $url
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property string|null $title
 * @property string|null $message
 * @property string|null $branch_id
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $read_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification forCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withoutTrashed()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models\Notification{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_read
 * @property string|null $user_id
 * @property string|null $users
 * @property string|null $url
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property string|null $title
 * @property string|null $message
 * @property string|null $branch_id
 * @property string|null $data
 * @property string|null $read_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification withoutTrashed()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models\Observation{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string|null $practitioner_id
 * @property string|null $patient_id
 * @property string|null $encounter_id
 * @property string $status Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.
 * @property string $category Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi Observation Category Codes.
 * @property string $code Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.
 * @property string|null $effective_date_time Berisi data mengenai kapan observasi dilakukan
 * @property \Illuminate\Support\Carbon|null $issued Berisi data tanggal dan waktu versi observasi ini tersedia, biasanya setelah hasilnya ditinjau/direview dan diverifikasi
 * @property int $value_value Berisi data mengenai informasi hasil aktual dari pengamatan.
 * @property string $value_code Berisi data mengenai informasi hasil aktual dari pengamatan.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservation|null $OHObservation
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \App\Models\Practitiont\Practitioner|null $practitioner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereEffectiveDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereValueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation whereValueValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Observation withoutTrashed()
 */
	class Observation extends \Eloquent {}
}

namespace App\Models\Observation\OneHealth{
/**
 * @property string $id
 * @property string|null $observation_id
 * @property string|null $id_observation
 * @property string|null $one_health_organization_id
 * @property string|null $one_health_practitioner_id
 * @property string|null $one_health_patient_id
 * @property string|null $one_health_encounter_id
 * @property string $status Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.
 * @property string $subject_reference Berisi data pasien yang memiliki hasil observasi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group | Device | Location
 * @property string $performer_reference Berisi data siapa yang bertanggung jawab untuk menyatakan nilai observasi sebagai "benar" dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Practitioner | PractitionerRole | Organization | CareTeam | Patient | RelatedPerson
 * @property string $encounter_reference Berisi data kunjungan di mana hasil observasi didapatkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Encounter
 * @property \Illuminate\Support\Carbon|null $effective_date_time Berisi data mengenai kapan observasi dilakukan
 * @property \Illuminate\Support\Carbon|null $issued Berisi data tanggal dan waktu versi observasi ini tersedia, biasanya setelah hasilnya ditinjau/direview dan diverifikasi
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Encounter\OneHealth\OneHealthEncounter|null $OHEncounter
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservationCategory|null $OHObservationCategory
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservationCode|null $OHObservationCode
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservationValueQuantity|null $OHObservationValueQuantity
 * @property-read \App\Models\Company\OneHealth\OneHealthOrganization|null $OHOrganization
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitioner
 * @property-read \App\Models\Observation\Observation|null $observation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereEffectiveDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereEncounterReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereIdObservation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereIssued($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereObservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereOneHealthEncounterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereOneHealthOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereOneHealthPractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation wherePerformerReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereSubjectReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservation withoutTrashed()
 */
	class OneHealthObservation extends \Eloquent {}
}

namespace App\Models\Observation\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_observation_id
 * @property string $coding_system Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.
 * @property string $coding_code Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.
 * @property string $coding_display Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservation|null $OHObservation
 * @property-read \App\Models\Master\CodeSystem\Observation\MasterObservationCategory|null $category
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereOneHealthObservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCategory withoutTrashed()
 */
	class OneHealthObservationCategory extends \Eloquent {}
}

namespace App\Models\Observation\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_observation_id
 * @property string $coding_system Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.
 * @property string $coding_code Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.
 * @property string $coding_display Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservation|null $OHObservation
 * @property-read \App\Models\Master\CodeSystem\Observation\MasterObservationCode|null $code
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereOneHealthObservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationCode withoutTrashed()
 */
	class OneHealthObservationCode extends \Eloquent {}
}

namespace App\Models\Observation\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_observation_id Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.
 * @property string $system Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.
 * @property int $value Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.
 * @property string $code Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.
 * @property string $unit Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Observation\OneHealth\OneHealthObservation|null $OHObservation
 * @property-read \App\Models\Master\CodeSystem\Observation\MasterObservationValueQuantity|null $codeValue
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereOneHealthObservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthObservationValueQuantity withoutTrashed()
 */
	class OneHealthObservationValueQuantity extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $patient_id
 * @property string|null $id_patient id yang dapat dari respon satu sehat
 * @property string $name_use Berisi data nama penjamin dengan tipe data code.
 * @property string $name_text Berisi data nama penjamin dengan tipe data string.
 * @property \App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender|null $gender Berisi data jenis kelamin pasien dengan tipe data code, yang nilainya mengacu pada salah satu data di terminologi dengan nama AdministrativeGender.
 * @property \Illuminate\Support\Carbon|null $birth_date Berisi data tanggal lahir pasien dengan tipe data date dalam format YYYY-MM-DD.
 * @property string|null $deceased_date Berisi data yang menunjukkan apakah individu tersebut meninggal atau tidak dengan tipe data dateTime
 * @property bool $deceased_boolean Berisi data yang menunjukkan apakah individu tersebut meninggal atau tidak dengan tipe data boolean.
 * @property bool $active Berisi data apakah catatan pasien aktif digunakan dengan tipe data boolean.
 * @property string $meta_profile
 * @property string $marital_status_coding_system Berisi data status perkawinan (sipil) terakhir pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi Marital Status Codes
 * @property string|null $marital_status_coding_code Berisi data status perkawinan (sipil) terakhir pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi Marital Status Codes
 * @property string|null $marital_status_coding_display Berisi data status perkawinan (sipil) terakhir pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi Marital Status Codes
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\OneHealth\OneHealthCondition> $OHConditions
 * @property-read int|null $o_h_conditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEncounter> $OHEncounter
 * @property-read int|null $o_h_encounter_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest> $OHMedicationReqs
 * @property-read int|null $o_h_medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservation> $OHObservation
 * @property-read int|null $o_h_observation_count
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatientAddress|null $OHPatientAddress
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatientContactRelationship|null $OHPatientContactRelationship
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\OneHealth\OneHealthPatientIdentifier> $OHPatientIdentifiers
 * @property-read int|null $o_h_patient_identifiers_count
 * @property-read \App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus|null $maritalStatus
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereDeceasedBoolean($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereDeceasedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereIdPatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereMaritalStatusCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereMaritalStatusCodingDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereMaritalStatusCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereMetaProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereNameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereNameUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatient withoutTrashed()
 */
	class OneHealthPatient extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_patient_id
 * @property string $use Berisi data penggunaan alamat organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi AddressUse.
 * @property string|null $line Berisi satu atau lebih data nama, blok, no jalan atau no rumah dengan tipe data string.
 * @property string|null $city Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.
 * @property string|null $postal_code Berisi data kode pos dengan tipe data string.
 * @property string $country Berisi data kode negara berdasarkan ISO 3316 2-letter (contoh: ID) dengan dengan tipe data string.
 * @property string $extention_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\OneHealth\OneHealthPatientAddressExtension> $extensions
 * @property-read int|null $extensions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereExtentionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddress withoutTrashed()
 */
	class OneHealthPatientAddress extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_patient_address_id
 * @property string|null $url Source of the definition for the extension code - a logical name or a URL. value : province/city/district/village/rt/rw
 * @property string|null $value_code value of master data region
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatientAddress|null $OHPatientAddress
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereOneHealthPatientAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension whereValueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientAddressExtension withoutTrashed()
 */
	class OneHealthPatientAddressExtension extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_patient_id
 * @property string $name_use Berisi data nama penjamin dengan tipe data code.
 * @property string|null $name_text Berisi data nama penjamin dengan tipe data string.
 * @property string $relationship_coding_system Berisi data mengenai hubungan antara pasien dan orang yang dihubungi dengan tipe data Coding, yang nilainya mengacu pada data terminologi PatientContactRelationship.
 * @property string|null $relationship_coding_code Berisi data mengenai hubungan antara pasien dan orang yang dihubungi dengan tipe data Coding, yang nilainya mengacu pada data terminologi PatientContactRelationship.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\OneHealth\OneHealthPatientContactTelecom> $contactTelecoms
 * @property-read int|null $contact_telecoms_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereNameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereNameUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereRelationshipCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereRelationshipCodingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactRelationship withoutTrashed()
 */
	class OneHealthPatientContactRelationship extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_patient_contact_relationship_id
 * @property string|null $system Berisi data jenis kontak dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointSystem.
 * @property string|null $value Berisi data nomor/email/website kontak organisasi dengan tipe data string.
 * @property string $use Berisi data penggunaan kontak organisasi dengan tipe data code, yang nilainya mengacu pada data terminologi ContactPointUse.
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatientContactRelationship|null $OHPatientContactRelationship
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereOneHealthPatientContactRelationshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientContactTelecom withoutTrashed()
 */
	class OneHealthPatientContactTelecom extends \Eloquent {}
}

namespace App\Models\Patient\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_patient_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string|null $system Di mana isi dari parameter {patient-ihs-number} adalah ID Patient yang didapatkan dari master pasien indeks.
 * @property string $value Berisi kode atau nomor pasien. (value of one_health_patient.id)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereOneHealthPatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPatientIdentifier withoutTrashed()
 */
	class OneHealthPatientIdentifier extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string|null $user_id
 * @property string|null $ihs_number
 * @property string|null $blood_group
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $birth_date Berisi data tanggal lahir pasien.
 * @property \App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender|null $gender Jenis kelamin
 * @property \Illuminate\Support\Carbon|null $deceased_date Berisi data yang menunjukkan apakah individu tersebut meninggal atau tidak.
 * @property bool $identity_card_mother Nomor NIK Ibu
 * @property string|null $identity_card Nomor NIK
 * @property string|null $passport_number Nomor Pasport
 * @property string|null $family_card_number Nomor Kartu keluarga
 * @property string|null $marital_status Berisi data status perkawinan (sipil) terakhir pasien dengan tipe data Coding, yang nilainya mengacu pada data terminologi Marital Status Codes.
 * @property string $status
 * @property string|null $phone
 * @property string|null $email
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Patient\OneHealth\OneHealthPatient|null $OHPatient
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Condition\Condition> $conditions
 * @property-read int|null $conditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\Encounter> $encounters
 * @property-read int|null $encounters_count
 * @property-read \App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus|null $maritalStatus
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $medicationReqs
 * @property-read int|null $medication_reqs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\PatientCompany> $patientCompany
 * @property-read int|null $patient_company_count
 * @property-read \App\Models\Patient\PatientContactRelationship|null $patientContactRelationship
 * @property-read \App\Models\Patient\PatientDetail|null $patientDetail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $performerMedicationDispenses
 * @property-read int|null $performer_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $requestMedicationReqs
 * @property-read int|null $request_medication_reqs_count
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\User\UserCompanyRole|null $userCompanyRole
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeceasedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereFamilyCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIdentityCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIdentityCardMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereIhsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePassportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Patient withoutTrashed()
 */
	class Patient extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $patient_id
 * @property string $use Berisi data penggunaan alamat pasien dengan tipe data code, yang nilainya mengacu pada data terminologi AddressUse
 * @property string $line Berisi satu atau lebih data nama, blok, no jalan atau no rumah dengan tipe data
 * @property string $city Berisi satu data kota
 * @property string $postal_code Berisi data kode pos
 * @property string $country Berisi data kode negara berdasarkan ISO 3316 2-letter (contoh: ID)
 * @property string $province_code Berisi satu data kode provinsi
 * @property string $city_code Berisi satu data kode kota
 * @property string $district_code Berisi satu data kode kecamatan
 * @property string $sub_district_code Berisi satu data kode kelurahan
 * @property string $rt Berisi satu data nomor rt
 * @property string $rw Berisi satu data nomor rw
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereSubDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientAddress withoutTrashed()
 */
	class PatientAddress extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $patient_id
 * @property string $company_id
 * @property string|null $medical_number_record
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereMedicalNumberRecord($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientCompany withoutTrashed()
 */
	class PatientCompany extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $patient_id
 * @property string $name_use Berisi data nama penjamin dengan tipe data code.
 * @property string $name_text Berisi data nama penjamin dengan tipe data string.
 * @property string $relationship_coding_code Berisi data mengenai hubungan antara pasien dan orang yang dihubungi dengan tipe data Coding, yang nilainya mengacu pada data terminologi PatientContactRelationship.
 * @property string|null $phone
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \App\Models\Master\CodeSystem\Patient\MasterPatientContactRelationship|null $relationshipCodingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereNameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereNameUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereRelationshipCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContact withoutTrashed()
 */
	class PatientContact extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $patient_id
 * @property string|null $name Berisi data nama penjamin dengan tipe data string.
 * @property string|null $relationship_coding_code Berisi data mengenai hubungan antara pasien dan orang yang dihubungi dengan tipe data Coding, yang nilainya mengacu pada data terminologi PatientContactRelationship.
 * @property string|null $phone
 * @property string|null $email
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \App\Models\Master\CodeSystem\Patient\MasterPatientContactRelationship|null $relationshipCodingCode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereRelationshipCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientContactRelationship withoutTrashed()
 */
	class PatientContactRelationship extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string|null $patient_id
 * @property string|null $province_code Kode provinsi by one health
 * @property string|null $province
 * @property string|null $city_code Kode kabupaten by one health
 * @property string|null $city
 * @property string|null $district_code Kode kecamatan by one health
 * @property string|null $district
 * @property string|null $sub_district_code Kode kelurahan by one health
 * @property string|null $sub_district
 * @property string|null $postal_code
 * @property string|null $address
 * @property string $country
 * @property string|null $rt Kode RT by one health
 * @property string|null $rw Kode RW by one health
 * @property string $longitude Kode longitude by one health
 * @property string $latitude Kode latitude by one health
 * @property string $altitude Kode altitude by one health
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereSubDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereSubDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDetail withoutTrashed()
 */
	class PatientDetail extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $patient_id
 * @property string $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse
 * @property string $system Berisi data yang nilainya memiliki format : nik, paspor, kk
 * @property string $value Berisi kode atau nomor pasien.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property-read \App\Models\Patient\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIdentifier withoutTrashed()
 */
	class PatientIdentifier extends \Eloquent {}
}

namespace App\Models\Patient{
/**
 * @property string $id
 * @property string $referrer_id
 * @property string $referred_id
 * @property string|null $transaction_id
 * @property numeric $amount
 * @property string $incentive_type persen or rupiah
 * @property string $status
 * @property string|null $month
 * @property string|null $year
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $referred
 * @property-read \App\Models\User|null $referrer
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereIncentiveType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereReferredId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereReferrerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientReferralIncentive withoutTrashed()
 */
	class PatientReferralIncentive extends \Eloquent {}
}

namespace App\Models\PaymentMethod{
/**
 * @property string $id
 * @property string $name
 * @property string|null $code
 * @property string $type
 * @property float $value
 * @property string $type_admin_fee
 * @property float $value_admin_fee
 * @property bool $is_offline_payment
 * @property bool $is_single_payment
 * @property string|null $account_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Account\Account|null $account
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionPayment> $transactionPayments
 * @property-read int|null $transaction_payments_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereIsOfflinePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereIsSinglePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereTypeAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereValueAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod withoutTrashed()
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models\Poly{
/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Poly withoutTrashed()
 */
	class Poly extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $practitioner_id
 * @property string|null $id_practitiont ID practitiont dari satu sehat
 * @property string $name_text Berisi satu atau lebih data mengenai nama tenaga kesehatan dengan tipe data HumanName.
 * @property string $name_use
 * @property \Illuminate\Support\Carbon $birth_date Berisi satu atau lebih data mengenai informasi tanggal lahir tenaga kesehatan dengan tipe data date.
 * @property string $gender Berisi satu atau lebih data mengenai informasi jenis kelamin tenaga kesehatan untuk keperluan administrasi dan pencatatan dengan tipe data code.
 * @property string|null $full_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\OneHealth\OneHealthEnconterParticipant> $OHEncounterParticipants
 * @property-read int|null $o_h_encounter_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense> $OHMedicationDispenses
 * @property-read int|null $o_h_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\OneHealth\OneHealthObservation> $OHObservation
 * @property-read int|null $o_h_observation_count
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitiontAddress|null $OHPractitiontAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Practitiont\OneHealth\OneHealthPractitiontIdentifier> $OHPractitiontIdentifiers
 * @property-read int|null $o_h_practitiont_identifiers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Practitiont\OneHealth\OneHealthPractitiontQualificationCodeCoding> $OHPractitiontQualificationCodeCodings
 * @property-read int|null $o_h_practitiont_qualification_code_codings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Practitiont\OneHealth\OneHealthPractitiontQualificationIndentifier> $OHPractitiontQualificationIdentifiers
 * @property-read int|null $o_h_practitiont_qualification_identifiers_count
 * @property-read \App\Models\Practitiont\Practitioner|null $practitioner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereFullUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereIdPractitiont($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereNameText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereNameUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitioner withoutTrashed()
 */
	class OneHealthPractitioner extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_practitiont_id
 * @property string $use Berisi data penggunaan alamat dengan tipe data code.
 * @property string $line Berisi data alamat lengkap tenaga kesehatan dengan tipe data string.
 * @property string $city Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.
 * @property string $country Berisi data kode negara berdasarkan ISO 3316 2-letter (contoh: ID) dengan tipe data string.
 * @property string|null $postal_code Berisi data kode pos yang menunjuk wilayah yang ditentukan oleh layanan pos dengan tipe data string.
 * @property string $extention_url
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitiont
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Practitiont\OneHealth\OneHealthPractitiontAddressExtension> $extensions
 * @property-read int|null $extensions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereExtentionUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereOneHealthPractitiontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddress withoutTrashed()
 */
	class OneHealthPractitiontAddress extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_practitiont_address_id
 * @property string $url Source of the definition for the extension code - a logical name or a URL. value : province/city/district/village
 * @property string $value_code value of master data region
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitiontAddress|null $OHPractitiontAddress
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereOneHealthPractitiontAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension whereValueCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontAddressExtension withoutTrashed()
 */
	class OneHealthPractitiontAddressExtension extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_practitiont_id
 * @property string|null $system Di mana isi dari parameter
 * @property string|null $use Berisi data dengan tipe data code, yang nilainya mengacu pada data terminologi IdentifierUse.
 * @property string $value BerIsi kode atau nomor
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitiont
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereOneHealthPractitiontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontIdentifier withoutTrashed()
 */
	class OneHealthPractitiontIdentifier extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_practitiont_id
 * @property string|null $code
 * @property string|null $display
 * @property string|null $system
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitiont
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereOneHealthPractitiontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationCodeCoding withoutTrashed()
 */
	class OneHealthPractitiontQualificationCodeCoding extends \Eloquent {}
}

namespace App\Models\Practitiont\OneHealth{
/**
 * @property string $id
 * @property string|null $one_health_practitiont_id
 * @property string|null $system
 * @property string|null $value
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitiont
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereOneHealthPractitiontId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OneHealthPractitiontQualificationIndentifier withoutTrashed()
 */
	class OneHealthPractitiontQualificationIndentifier extends \Eloquent {}
}

namespace App\Models\Practitiont{
/**
 * @property string $id
 * @property string|null $user_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitiont\OneHealth\OneHealthPractitioner|null $OHPractitioner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Encounter\EncounterPractitiont> $encounterPractitionts
 * @property-read int|null $encounter_practitionts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $medicationDispenses
 * @property-read int|null $medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Observation\Observation> $observations
 * @property-read int|null $observations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationDispense\MedicationDispense> $performerMedicationDispenses
 * @property-read int|null $performer_medication_dispenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicationRequest\MedicationRequest> $requestMedicationReqs
 * @property-read int|null $request_medication_reqs_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner withoutTrashed()
 */
	class Practitioner extends \Eloquent {}
}

namespace App\Models\Printer{
/**
 * @property string $id
 * @property string|null $device_id
 * @property string|null $device_name
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Printer withoutTrashed()
 */
	class Printer extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string|null $product_id
 * @property string|null $sku_number
 * @property string $name
 * @property string|null $description
 * @property string|null $product_category_id
 * @property string|null $product_factory_id
 * @property string|null $product_rack_id
 * @property string|null $product_type_id
 * @property string|null $code_coding_code
 * @property string|null $form_coding_code
 * @property string $company_id
 * @property string|null $item_code
 * @property string|null $item_display
 * @property string|null $display
 * @property string|null $registration_path
 * @property bool|null $is_narcotics
 * @property bool|null $is_non_stock
 * @property int $medicine_dosage
 * @property string|null $dosage_unit
 * @property int $numerator_value
 * @property string|null $numerator_code
 * @property int $denominator_value
 * @property string|null $denominator_code
 * @property string|null $unit_id
 * @property int $normal
 * @property int $recipe
 * @property bool $is_stock_ingredient
 * @property int|null $minimun_stock
 * @property int|null $safety_stock
 * @property int|null $maximum_stock
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $type_incentive_nurse
 * @property numeric $incentive_nurse
 * @property string $type_incentive_doctor
 * @property numeric $incentive_doctor
 * @property-read \App\Models\Company\Company|null $company
 * @property-read mixed $name_sku
 * @property-read \App\Models\Product\ProductExpiredDate|null $nearestExpiredDate
 * @property-read \App\Models\Product\ProductCategory|null $productCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductExpiredDate> $productExpiredDates
 * @property-read int|null $product_expired_dates_count
 * @property-read \App\Models\Product\ProductFactory|null $productFactory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductPackage> $productPackages
 * @property-read int|null $product_packages_count
 * @property-read \App\Models\Product\ProductPrice|null $productPrice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductPriceHistory> $productPriceHistories
 * @property-read int|null $product_price_histories_count
 * @property-read \App\Models\Product\ProductRack|null $productRack
 * @property-read \App\Models\Product\ProductStock|null $productStock
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductStockHistory> $productStockHistories
 * @property-read int|null $product_stock_histories_count
 * @property-read \App\Models\Product\ProductType|null $productType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductUnit> $productUnits
 * @property-read int|null $product_units_count
 * @property-read \App\Models\Unit\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCodeCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDenominatorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDenominatorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDosageUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereFormCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIncentiveDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIncentiveNurse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsNarcotics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsNonStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsStockIngredient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereItemDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMaximumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMedicineDosage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereMinimunStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNumeratorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNumeratorValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductFactoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductRackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereProductTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereRegistrationPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSafetyStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSkuNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereTypeIncentiveDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereTypeIncentiveNurse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property int $normal
 * @property int $recipe
 * @property numeric $price
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory withoutTrashed()
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_stock_id
 * @property string $product_id
 * @property string $branch_id
 * @property string $expired_date
 * @property string|null $batch_number
 * @property int|null $quantity
 * @property string|null $user_id
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereProductStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductExpiredDate withoutTrashed()
 */
	class ProductExpiredDate extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductFactory withoutTrashed()
 */
	class ProductFactory extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string $product_type_id
 * @property string|null $batch_number
 * @property string|null $expired_date
 * @property int $quantity
 * @property numeric $hpp_average
 * @property numeric $selling_price
 * @property numeric $selling_price_recipe
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property bool $is_process_finance
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereIsProcessFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereProductTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereSellingPriceRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductImportStock withoutTrashed()
 */
	class ProductImportStock extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string|null $product_id
 * @property string|null $product_child_id
 * @property string $name
 * @property int $quantity
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\Product|null $productChild
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereProductChildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPackage withoutTrashed()
 */
	class ProductPackage extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string $branch_id
 * @property numeric $hpp_average
 * @property numeric $hpp_average_generate
 * @property numeric $price_generate
 * @property numeric $price
 * @property numeric $recipe_generate
 * @property numeric $recipe
 * @property numeric $price_discount
 * @property bool $is_updated
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice byBranch($branchId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice byProduct($productId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereHppAverageGenerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereIsUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice wherePriceGenerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereRecipeGenerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPrice withoutTrashed()
 */
	class ProductPrice extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string|null $product_price_id
 * @property string|null $user_id
 * @property string $branch_id
 * @property string|null $product_unit_id
 * @property string|null $purchase_order_item_id
 * @property string|null $transaction_detail_id
 * @property string|null $product_import_stock_id
 * @property numeric $price
 * @property numeric $quantity
 * @property numeric $sub_total_price
 * @property numeric $hpp_average
 * @property bool $is_updated
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductPrice|null $productPrice
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereIsUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereProductImportStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereProductPriceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory wherePurchaseOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductPriceHistory withoutTrashed()
 */
	class ProductPriceHistory extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductRack withoutTrashed()
 */
	class ProductRack extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string $branch_id
 * @property int $quantity
 * @property int $quantity_lock
 * @property int $quantity_real
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read mixed $quantity_now
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\ProductStockHistory> $productStockHistories
 * @property-read int|null $product_stock_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereQuantityLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStock withoutTrashed()
 */
	class ProductStock extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string|null $product_stock_id
 * @property string|null $product_unit_id
 * @property string|null $purchase_order_item_id
 * @property string|null $transaction_detail_id
 * @property string|null $transaction_recipe_id
 * @property string|null $product_import_stock_id
 * @property string|null $dead_stock_id
 * @property string|null $stock_mutation_detail_id
 * @property string|null $user_id
 * @property string $branch_id
 * @property string $code
 * @property string $description
 * @property string|null $reference
 * @property string $date
 * @property int $quantity
 * @property string $type
 * @property numeric $price
 * @property numeric $sub_total_price
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductStock|null $productStock
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereDeadStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereProductImportStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereProductStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory wherePurchaseOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereStockMutationDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductStockHistory withoutTrashed()
 */
	class ProductStockHistory extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductType withoutTrashed()
 */
	class ProductType extends \Eloquent {}
}

namespace App\Models\Product{
/**
 * @property string $id
 * @property string $product_id
 * @property string $unit_id
 * @property int $quantity
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Unit\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit search($term)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductUnit withoutTrashed()
 */
	class ProductUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $promotion_scope
 * @property string $type
 * @property string $promotion_type
 * @property numeric|null $promotion_value
 * @property numeric|null $max_discount
 * @property numeric $minimum_purchase
 * @property numeric|null $maximum_purchase
 * @property int|null $buy_quantity
 * @property int|null $get_quantity
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $total_quota
 * @property int $quota_per_user
 * @property int $used_count
 * @property bool $is_unlimited
 * @property bool $is_active
 * @property bool $is_stackable
 * @property bool $is_auto_apply
 * @property string|null $applicable_days
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $user_types
 * @property string|null $user_ids
 * @property string|null $product_ids
 * @property string|null $company_ids
 * @property string|null $exclude_product_ids
 * @property string|null $terms_conditions
 * @property string|null $image
 * @property string|null $banner_text
 * @property int $priority
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $buy_products
 * @property array<array-key, mixed>|null $get_products
 * @property string|null $buy_get_mode
 * @property array<array-key, mixed>|null $bundle_products
 * @property numeric|null $bundle_price
 * @property numeric|null $bundle_discount
 * @property array<array-key, mixed>|null $discount_tiers
 * @property array<array-key, mixed>|null $product_discounts
 * @property numeric|null $cashback_percentage
 * @property numeric|null $max_cashback
 * @property string|null $cashback_type
 * @property numeric|null $free_shipping_threshold
 * @property numeric|null $points_multiplier
 * @property int|null $bonus_points
 * @property int|null $max_usage
 * @property int $current_usage
 * @property int|null $max_usage_per_user
 * @property bool $is_first_purchase_only
 * @property string $product_discount_mode
 * @property string $discount_application
 * @property string|null $volume_tiers
 * @property string|null $membership_levels
 * @property string|null $seasonal_conditions
 * @property string|null $usage_analytics
 * @property string|null $customer_segments
 * @property string|null $geographic_restrictions
 * @property string|null $time_restrictions
 * @property bool $allow_combination
 * @property string|null $combination_rules
 * @property int|null $max_discount_per_item
 * @property numeric|null $max_total_discount
 * @property bool $requires_code
 * @property string|null $promo_code_pattern
 * @property string|null $test_group
 * @property numeric|null $test_percentage
 * @property string|null $performance_metrics
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereAllowCombination($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereApplicableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBannerText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBonusPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundleDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundlePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundleProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyGetMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCashbackPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCashbackType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCombinationRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCompanyIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCurrentUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCustomerSegments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountApplication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountTiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereExcludeProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereFreeShippingThreshold($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGeographicRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGetProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGetQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsAutoApply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsFirstPurchaseOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsStackable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxCashback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxDiscountPerItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxUsagePerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaximumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMembershipLevels($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMinimumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePerformanceMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePointsMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductDiscountMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromoCodePattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereQuotaPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereRequiresCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereSeasonalConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTestGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTestPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTimeRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTotalQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUsageAnalytics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUserIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereVolumeTiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withoutTrashed()
 */
	class Promotion extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $promotion_scope
 * @property string $type
 * @property string $promotion_type
 * @property numeric|null $promotion_value
 * @property numeric|null $max_discount
 * @property numeric $minimum_purchase
 * @property numeric|null $maximum_purchase
 * @property int|null $buy_quantity
 * @property int|null $get_quantity
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $total_quota
 * @property int $quota_per_user
 * @property int $used_count
 * @property bool $is_unlimited
 * @property bool $is_active
 * @property bool $is_stackable
 * @property bool $is_auto_apply
 * @property array<array-key, mixed>|null $applicable_days
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property array<array-key, mixed>|null $user_types
 * @property array<array-key, mixed>|null $user_ids
 * @property array<array-key, mixed>|null $product_ids
 * @property string|null $company_ids
 * @property array<array-key, mixed>|null $exclude_product_ids
 * @property array<array-key, mixed>|null $terms_conditions
 * @property string|null $image
 * @property string|null $banner_text
 * @property int $priority
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed>|null $buy_products
 * @property array<array-key, mixed>|null $get_products
 * @property string|null $buy_get_mode
 * @property array<array-key, mixed>|null $bundle_products
 * @property numeric|null $bundle_price
 * @property numeric|null $bundle_discount
 * @property array<array-key, mixed>|null $discount_tiers
 * @property array<array-key, mixed>|null $product_discounts
 * @property numeric|null $cashback_percentage
 * @property numeric|null $max_cashback
 * @property string|null $cashback_type
 * @property numeric|null $free_shipping_threshold
 * @property numeric|null $points_multiplier
 * @property int|null $bonus_points
 * @property int|null $max_usage
 * @property int $current_usage
 * @property int|null $max_usage_per_user
 * @property bool $is_first_purchase_only
 * @property string $product_discount_mode
 * @property string $discount_application
 * @property array<array-key, mixed>|null $volume_tiers
 * @property array<array-key, mixed>|null $membership_levels
 * @property array<array-key, mixed>|null $seasonal_conditions
 * @property array<array-key, mixed>|null $usage_analytics
 * @property array<array-key, mixed>|null $customer_segments
 * @property array<array-key, mixed>|null $geographic_restrictions
 * @property array<array-key, mixed>|null $time_restrictions
 * @property bool $allow_combination
 * @property array<array-key, mixed>|null $combination_rules
 * @property int|null $max_discount_per_item
 * @property numeric|null $max_total_discount
 * @property bool $requires_code
 * @property string|null $promo_code_pattern
 * @property string|null $test_group
 * @property numeric|null $test_percentage
 * @property array<array-key, mixed>|null $performance_metrics
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Promotion\PromotionUsage> $usages
 * @property-read int|null $usages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion byCode($code)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion validDate()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereAllowCombination($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereApplicableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBannerText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBonusPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundleDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundlePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBundleProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyGetMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereBuyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCashbackPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCashbackType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCombinationRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCompanyIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCurrentUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereCustomerSegments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountApplication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereDiscountTiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereExcludeProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereFreeShippingThreshold($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGeographicRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGetProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereGetQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsAutoApply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsFirstPurchaseOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsStackable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereIsUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxCashback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxDiscountPerItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaxUsagePerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMaximumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMembershipLevels($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereMinimumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePerformanceMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePointsMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductDiscountMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromoCodePattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion wherePromotionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereQuotaPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereRequiresCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereSeasonalConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTestGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTestPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTimeRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereTotalQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUsageAnalytics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUserIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion whereVolumeTiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Promotion withoutTrashed()
 */
	class Promotion extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionDetail withoutTrashed()
 */
	class PromotionDetail extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $promotion_scope
 * @property string $type
 * @property string $promotion_type
 * @property numeric|null $promotion_value
 * @property numeric|null $max_discount
 * @property numeric $minimum_purchase
 * @property numeric|null $maximum_purchase
 * @property int|null $buy_quantity
 * @property int|null $get_quantity
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $total_quota
 * @property int $quota_per_user
 * @property int $used_count
 * @property bool $is_unlimited
 * @property bool $is_active
 * @property bool $is_stackable
 * @property bool $is_auto_apply
 * @property string|null $applicable_days
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $user_types
 * @property string|null $user_ids
 * @property array<array-key, mixed>|null $product_ids
 * @property string|null $company_ids
 * @property string|null $exclude_product_ids
 * @property array<array-key, mixed>|null $terms_conditions
 * @property string|null $image
 * @property string|null $banner_text
 * @property int $priority
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $company_id
 * @property int $order
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $buy_products
 * @property string|null $get_products
 * @property string|null $buy_get_mode
 * @property array<array-key, mixed>|null $bundle_products
 * @property numeric|null $bundle_price
 * @property numeric|null $bundle_discount
 * @property string|null $discount_tiers
 * @property string|null $product_discounts
 * @property numeric|null $cashback_percentage
 * @property numeric|null $max_cashback
 * @property string|null $cashback_type
 * @property numeric|null $free_shipping_threshold
 * @property numeric|null $points_multiplier
 * @property int|null $bonus_points
 * @property int|null $max_usage
 * @property int $current_usage
 * @property int|null $max_usage_per_user
 * @property bool $is_first_purchase_only
 * @property string $product_discount_mode
 * @property string $discount_application
 * @property string|null $volume_tiers
 * @property string|null $membership_levels
 * @property string|null $seasonal_conditions
 * @property string|null $usage_analytics
 * @property string|null $customer_segments
 * @property string|null $geographic_restrictions
 * @property string|null $time_restrictions
 * @property bool $allow_combination
 * @property string|null $combination_rules
 * @property int|null $max_discount_per_item
 * @property numeric|null $max_total_discount
 * @property bool $requires_code
 * @property string|null $promo_code_pattern
 * @property string|null $test_group
 * @property numeric|null $test_percentage
 * @property string|null $performance_metrics
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $creator
 * @property-read bool $is_current
 * @property-read bool $is_expired
 * @property-read bool $is_not_started
 * @property-read int|null $remaining_usage
 * @property-read float $usage_percentage
 * @property-read \App\Models\User|null $updater
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Promotion\PromotionUsageHistory> $usageHistories
 * @property-read int|null $usage_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent available()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent current()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent featured()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent forCustomer($customerId, $customerType = 'existing')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereAllowCombination($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereApplicableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBannerText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBonusPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBundleDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBundlePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBundleProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBuyGetMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBuyProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereBuyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCashbackPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCashbackType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCombinationRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCompanyIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCurrentUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereCustomerSegments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereDiscountApplication($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereDiscountTiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereExcludeProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereFreeShippingThreshold($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereGeographicRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereGetProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereGetQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereIsAutoApply($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereIsFirstPurchaseOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereIsStackable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereIsUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxCashback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxDiscountPerItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxTotalDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaxUsagePerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMaximumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMembershipLevels($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereMinimumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePerformanceMetrics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePointsMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereProductDiscountMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereProductDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePromoCodePattern($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePromotionScope($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent wherePromotionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereQuotaPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereRequiresCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereSeasonalConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereTestGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereTestPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereTimeRestrictions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereTotalQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUsageAnalytics($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUserIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionEvent whereVolumeTiers($value)
 */
	class PromotionEvent extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string $name
 * @property string|null $description
 * @property string $code
 * @property string $type
 * @property string|null $discount_type
 * @property numeric|null $discount_value
 * @property numeric|null $max_discount
 * @property int|null $buy_quantity
 * @property int|null $get_quantity
 * @property numeric|null $bundle_price
 * @property array<array-key, mixed>|null $bundle_products
 * @property string|null $special_type
 * @property numeric|null $cashback_percentage
 * @property int|null $points_multiplier
 * @property numeric $minimum_purchase
 * @property bool $is_active
 * @property bool $is_unlimited
 * @property int|null $total_quota
 * @property int $quota_per_user
 * @property int $used_count
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property array<array-key, mixed>|null $applicable_days
 * @property array<array-key, mixed>|null $applicable_products
 * @property array<array-key, mixed>|null $applicable_users
 * @property array<array-key, mixed>|null $applicable_user_types
 * @property array<array-key, mixed>|null $applicable_companies
 * @property array<array-key, mixed>|null $terms_conditions
 * @property bool $is_featured
 * @property bool $can_combine_with_other
 * @property string $schedule_type
 * @property array<array-key, mixed>|null $specific_days
 * @property string|null $specific_start_time
 * @property string|null $specific_end_time
 * @property bool $apply_time_to_days
 * @property array<array-key, mixed>|null $buy_x_get_y_rules
 * @property array<array-key, mixed>|null $discount_products
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product\Product|null $buyProduct
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified forToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified hasQuota()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified inDateRange()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified inTimeRange()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplicableCompanies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplicableDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplicableProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplicableUserTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplicableUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereApplyTimeToDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereBundlePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereBundleProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereBuyQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereBuyXGetYRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereCanCombineWithOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereCashbackPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereDiscountProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereGetQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereIsUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereMinimumPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified wherePointsMultiplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereQuotaPerUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereScheduleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereSpecialType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereSpecificDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereSpecificEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereSpecificStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereTermsConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereTotalQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified whereUsedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionSimplified withoutTrashed()
 */
	class PromotionSimplified extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property string $id
 * @property string $promotion_id
 * @property string|null $user_id
 * @property string|null $transaction_id
 * @property numeric $discount_amount
 * @property numeric $original_amount
 * @property numeric $final_amount
 * @property array<array-key, mixed>|null $applied_products
 * @property string $promotion_code
 * @property \Illuminate\Support\Carbon $used_at
 * @property string $status
 * @property string|null $notes
 * @property string|null $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Promotion\PromotionSimplified|null $promotion
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage byPromotion($promotionId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereAppliedProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereFinalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereOriginalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage wherePromotionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage wherePromotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsage whereUserId($value)
 */
	class PromotionUsage extends \Eloquent {}
}

namespace App\Models\Promotion{
/**
 * @property string $id
 * @property string $promotion_id
 * @property string $customer_id
 * @property string|null $order_id
 * @property numeric $order_amount
 * @property numeric $discount_amount
 * @property array<array-key, mixed>|null $applied_products
 * @property \Illuminate\Support\Carbon $used_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $customer
 * @property-read \App\Models\Promotion\PromotionEvent $promotion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory byCustomer($customerId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory byPromotion($promotionId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory inDateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereAppliedProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory wherePromotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PromotionUsageHistory whereUsedAt($value)
 */
	class PromotionUsageHistory extends \Eloquent {}
}

namespace App\Models\PurchaseOrder{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $purchase_return_id
 * @property string $supplier_id
 * @property string|null $branch_id
 * @property string|null $number
 * @property string $status
 * @property numeric $price
 * @property numeric $discount
 * @property numeric $grand_total
 * @property numeric $grand_total_real
 * @property numeric $price_total
 * @property numeric $tax_total
 * @property numeric $price_tax_total
 * @property string|null $note
 * @property bool $is_process_finance
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseOrder\PurchaseOrderItem> $purchaseOrderItems
 * @property-read int|null $purchase_order_items_count
 * @property-read \App\Models\PurchaseRequisition\PurchaseRequisition|null $purchaseRequisition
 * @property-read \App\Models\Supplier\Supplier|null $supplier
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereGrandTotalReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereIsProcessFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePriceTaxTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePriceTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder wherePurchaseReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereTaxTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrder withoutTrashed()
 */
	class PurchaseOrder extends \Eloquent {}
}

namespace App\Models\PurchaseOrder{
/**
 * @property string $id
 * @property string $purchase_order_id
 * @property string $purchase_requisition_item_id
 * @property string|null $purchase_return_index_id
 * @property string $product_unit_id
 * @property string $product_id
 * @property string $product_name
 * @property int $quantity
 * @property int $product_unit_quantity
 * @property int $quantity_bonus
 * @property int $quantity_accepted
 * @property int $quantity_less
 * @property int $quantity_return
 * @property int $quantity_total
 * @property int $quantity_detail
 * @property int $quantity_real
 * @property int $quantity_return_accepted
 * @property numeric $price
 * @property numeric $hna
 * @property numeric $ppn
 * @property numeric $hna_ppn
 * @property numeric $sub_total
 * @property numeric $discount
 * @property string|null $discount_type
 * @property numeric $discount_value
 * @property numeric $total
 * @property numeric $hna_total
 * @property numeric $hna_ppn_total
 * @property numeric $ppn_total
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductUnit|null $productUnit
 * @property-read \App\Models\PurchaseOrder\PurchaseOrder|null $purchaseOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereHna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereHnaPpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereHnaPpnTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereHnaTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePpnTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereProductUnitQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePurchaseRequisitionItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem wherePurchaseReturnIndexId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityLess($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityReturnAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereQuantityTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseOrderItem withoutTrashed()
 */
	class PurchaseOrderItem extends \Eloquent {}
}

namespace App\Models\PurchaseRequisition{
/**
 * @property string $id
 * @property string|null $purchase_order_id
 * @property string|null $purchase_return_id
 * @property string $user_id
 * @property string $number
 * @property string $status
 * @property string $company_id
 * @property string|null $branch_id
 * @property string|null $supplier_id
 * @property numeric $grand_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $type
 * @property string|null $notes
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\PurchaseOrder\PurchaseOrder|null $purchaseOrder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseRequisition\PurchaseRequisitionItem> $purchaseRequisitionItems
 * @property-read int|null $purchase_requisition_items_count
 * @property-read \App\Models\Supplier\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition wherePurchaseReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisition withoutTrashed()
 */
	class PurchaseRequisition extends \Eloquent {}
}

namespace App\Models\PurchaseRequisition{
/**
 * @property string $id
 * @property string|null $purchase_requisition_id
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property string $product_id
 * @property string $product_name
 * @property string|null $unit_id
 * @property string|null $product_unit_id
 * @property int $quantity
 * @property int $quantity_detail
 * @property int $quantity_real
 * @property string $status
 * @property string $type draft, purchase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductUnit|null $productUnit
 * @property-read \App\Models\PurchaseOrder\PurchaseOrderItem|null $purchaseOrderItem
 * @property-read \App\Models\PurchaseRequisition\PurchaseRequisition|null $purchaseRequisition
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem wherePurchaseRequisitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereQuantityDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionItem withoutTrashed()
 */
	class PurchaseRequisitionItem extends \Eloquent {}
}

namespace App\Models\PurchaseReturn{
/**
 * @property string $id
 * @property string $purchase_order_id
 * @property string $supplier_id
 * @property string $branch_id
 * @property string $return_number
 * @property string $date
 * @property numeric $price
 * @property numeric $grand_total
 * @property string $type
 * @property string|null $description
 * @property string $status
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\PurchaseOrder\PurchaseOrder|null $purchaseOrder
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseReturn\PurchaseReturnIndex> $purchaseReturnsItems
 * @property-read int|null $purchase_returns_items_count
 * @property-read \App\Models\Supplier\Supplier|null $supplier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereReturnNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturn withoutTrashed()
 */
	class PurchaseReturn extends \Eloquent {}
}

namespace App\Models\PurchaseReturn{
/**
 * @property string $id
 * @property string $purchase_return_id
 * @property string $purchase_order_item_id
 * @property string $product_unit_id
 * @property string $product_id
 * @property int $quantity
 * @property numeric $price
 * @property numeric $hna
 * @property numeric $ppn
 * @property numeric $hna_ppn
 * @property numeric $sub_total
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductUnit|null $productUnit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereHna($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereHnaPpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex wherePpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereProductUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex wherePurchaseOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex wherePurchaseReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseReturnIndex withoutTrashed()
 */
	class PurchaseReturnIndex extends \Eloquent {}
}

namespace App\Models\Role{
/**
 * @property string $id
 * @property string $role_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Spatie\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RoleCompany withoutTrashed()
 */
	class RoleCompany extends \Eloquent {}
}

namespace App\Models\Service{
/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service withoutTrashed()
 */
	class Service extends \Eloquent {}
}

namespace App\Models\Service{
/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property int $duration_days
 * @property numeric $price
 * @property bool $is_trial
 * @property bool $is_lifetime
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service\ServiceMonthDetail> $serviceMonthDetails
 * @property-read int|null $service_month_details_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereIsLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereIsTrial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonth withoutTrashed()
 */
	class ServiceMonth extends \Eloquent {}
}

namespace App\Models\Service{
/**
 * @property string $id
 * @property string $service_month_id
 * @property string $service_id
 * @property string $status
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereServiceMonthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServiceMonthDetail withoutTrashed()
 */
	class ServiceMonthDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $company_id
 * @property string $name
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_active
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Shift withoutTrashed()
 */
	class Shift extends \Eloquent {}
}

namespace App\Models\Spatie{
/**
 * @property string $uuid
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spatie\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App\Models\Spatie{
/**
 * @property string $uuid
 * @property string $name
 * @property string|null $company_id
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spatie\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App\Models\StockMutation{
/**
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property string|null $company_main_id
 * @property string|null $company_branch_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Company\Company|null $companyBranch
 * @property-read \App\Models\Company\Company|null $companyMain
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereCompanyBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereCompanyMainId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutation withoutTrashed()
 */
	class StockMutation extends \Eloquent {}
}

namespace App\Models\StockMutation{
/**
 * @property string $id
 * @property string $stock_mutation_id
 * @property string $product_id
 * @property string $product_branch_id
 * @property string $product_name
 * @property numeric $quantity_system
 * @property numeric $quantity
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereProductBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereStockMutationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMutationDetail withoutTrashed()
 */
	class StockMutationDetail extends \Eloquent {}
}

namespace App\Models\StockOpname{
/**
 * @property string $id
 * @property string $product_id
 * @property string|null $stock_opname_item_id
 * @property string|null $product_expired_date_id
 * @property int $quantity
 * @property int $quantity_system
 * @property int $quantity_difference
 * @property numeric $hpp_average
 * @property numeric $loss_value
 * @property numeric $excess_value
 * @property string|null $description
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereProductExpiredDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereQuantityDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereStockOpnameItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoryStockOpnameItem withoutTrashed()
 */
	class HistoryStockOpnameItem extends \Eloquent {}
}

namespace App\Models\StockOpname{
/**
 * @property string $id
 * @property string $code
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $description
 * @property string|null $company_id
 * @property string|null $user_id
 * @property string|null $branch_id
 * @property string $status
 * @property int $order
 * @property numeric $total_loss_value
 * @property numeric $total_excess_value
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string|null $approved_by
 * @property bool $is_process_finance
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockOpname\StockOpnameItem> $stockOpnameItems
 * @property-read int|null $stock_opname_items_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereIsProcessFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereTotalExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereTotalLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpname withoutTrashed()
 */
	class StockOpname extends \Eloquent {}
}

namespace App\Models\StockOpname{
/**
 * @property string $id
 * @property string $stock_opname_id
 * @property string $product_id
 * @property string|null $product_expired_date_id
 * @property int $quantity
 * @property int $quantity_system
 * @property int $quantity_difference
 * @property numeric $hpp_average
 * @property numeric $loss_value
 * @property numeric $excess_value
 * @property string|null $description
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Product\ProductExpiredDate|null $productExpiredDate
 * @property-read \App\Models\StockOpname\StockOpname|null $stockOpname
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockOpname\StockOpnameItemDetail> $stockOpnameItemDetails
 * @property-read int|null $stock_opname_item_details_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereProductExpiredDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereQuantityDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereStockOpnameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItem withoutTrashed()
 */
	class StockOpnameItem extends \Eloquent {}
}

namespace App\Models\StockOpname{
/**
 * @property string $id
 * @property string $stock_opname_id
 * @property string $stock_opname_item_id
 * @property string $product_id
 * @property string|null $product_expired_date_id
 * @property int $quantity
 * @property int $quantity_system
 * @property int $quantity_difference
 * @property numeric $hpp_average
 * @property numeric $loss_value
 * @property numeric $excess_value
 * @property string|null $description
 * @property string|null $branch_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereExcessValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereLossValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereProductExpiredDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereQuantityDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereQuantitySystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereStockOpnameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereStockOpnameItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockOpnameItemDetail withoutTrashed()
 */
	class StockOpnameItemDetail extends \Eloquent {}
}

namespace App\Models\Supplier{
/**
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property string $phone
 * @property string|null $address
 * @property string|null $province
 * @property string|null $city
 * @property string|null $district
 * @property string|null $sub_district
 * @property string $company_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereSubDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutTrashed()
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models\SystemSetting{
/**
 * @property string $id
 * @property int $tax
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemSetting withoutTrashed()
 */
	class SystemSetting extends \Eloquent {}
}

namespace App\Models\SystemUpdate{
/**
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $type_color
 * @property-read mixed $type_icon
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemUpdate withoutTrashed()
 */
	class SystemUpdate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $transaction_id
 * @property int $tenor
 * @property string $due_date
 * @property int $amount
 * @property string $status
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereTenor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionInstallment withoutTrashed()
 */
	class TransactionInstallment extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string $icd10_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Icd\Icd10|null $icd10
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SupportingTransactionIcd10 withoutTrashed()
 */
	class SupportingTransactionIcd10 extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $code
 * @property string|null $code_consultation
 * @property string|null $doctor_id
 * @property string|null $doctor_name
 * @property string|null $location_id
 * @property string|null $location_name
 * @property string|null $date
 * @property string|null $day
 * @property string|null $control_doctor_id
 * @property string|null $number_recipe
 * @property string|null $patient_id
 * @property string|null $user_type_id
 * @property string|null $patient_company_role_id
 * @property string|null $payment_method_single_payment_id
 * @property numeric $single_payment_admin_fee
 * @property numeric $single_payment_payment_amount
 * @property numeric $single_payment_payment_real
 * @property bool $is_single_payment
 * @property string|null $branch_id
 * @property string $type_customer
 * @property string $type_doctor
 * @property string|null $patient_name
 * @property numeric $first_service_price
 * @property numeric $service_other_price
 * @property numeric $price_product_price
 * @property numeric $product_price
 * @property numeric $second_service_price
 * @property numeric $embalage
 * @property numeric $sub_total_price_embalage
 * @property numeric $sub_total_price
 * @property string|null $discount_id
 * @property numeric $discount_real
 * @property numeric $discount
 * @property string $discount_type
 * @property numeric $discount_value
 * @property numeric $sub_total_price_before_rounding
 * @property numeric $rounding
 * @property numeric $rounding_remainder
 * @property numeric $grand_total_price
 * @property numeric $grand_total_price_admin_fee
 * @property numeric $payment_amount
 * @property numeric $payment_change
 * @property numeric $remaining_bill
 * @property string|null $pharmacy_id
 * @property string|null $pharmacy_name
 * @property string|null $cashier_id
 * @property string|null $cashier_name
 * @property string|null $company_id
 * @property string|null $created_by
 * @property string $status
 * @property bool $is_take_medicine
 * @property string $consultation
 * @property string $pharmacy
 * @property string $type
 * @property bool $is_outside_pharmacy
 * @property string|null $date_prepare
 * @property string|null $note
 * @property string|null $diagnosas
 * @property string|null $immunization
 * @property bool $is_process_finance
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $promotion_simplified_id
 * @property numeric $promotion_real
 * @property numeric $promotion
 * @property string $promotion_type
 * @property numeric $promotion_value
 * @property string|null $deposit_id
 * @property string|null $use_control_schedule_id
 * @property string|null $insurance_id
 * @property bool $is_insurance
 * @property bool $is_insurance_claim
 * @property string|null $insurance_number
 * @property bool $is_pending_payment
 * @property string $status_payment
 * @property array<array-key, mixed>|null $consent_actions
 * @property array<array-key, mixed>|null $consent_signee
 * @property string|null $doctor_referral_id
 * @property int|null $installment_count
 * @property string|null $installment_period
 * @property-read \App\Models\Branch\Branch|null $branch
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User\ControlDoctor|null $controlDoctor
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Deposit\Deposit|null $deposit
 * @property-read \App\Models\User|null $doctor
 * @property-read \App\Models\Encounter\Encounter|null $encounter
 * @property-read \App\Models\Insurance\Insurance|null $insurance
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \App\Models\User|null $patient
 * @property-read \App\Models\User\UserCompanyRole|null $patientCompanyRole
 * @property-read \App\Models\Poly\Poly|null $poly
 * @property-read \App\Models\Transaction\TransactionCondition|null $transactionCondition
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionDetailPackage> $transactionDetailPackages
 * @property-read int|null $transaction_detail_packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionDetail> $transactionDetails
 * @property-read int|null $transaction_details_count
 * @property-read \App\Models\Transaction\TransactionDiagnosis|null $transactionDiagnosis
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionIcd10> $transactionIcd10
 * @property-read int|null $transaction_icd10_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransactionInstallment> $transactionInstallments
 * @property-read int|null $transaction_installments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionNurse> $transactionNurses
 * @property-read int|null $transaction_nurses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionPayment> $transactionPayments
 * @property-read int|null $transaction_payments_count
 * @property-read \App\Models\Transaction\TransactionPhysicalExamination|null $transactionPhysicalExamination
 * @property-read \App\Models\Transaction\TransactionPrimary|null $transactionPrimary
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionRecipe> $transactionRecipes
 * @property-read int|null $transaction_recipes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCashierName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCodeConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereConsentActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereConsentSignee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereConsultation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereControlDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDatePrepare($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDepositId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiagnosas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiscountReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDoctorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDoctorReferralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereEmbalage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereFirstServicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereGrandTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereGrandTotalPriceAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereImmunization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereInstallmentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereInstallmentPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereInsuranceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereInsuranceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsInsuranceClaim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsOutsidePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsPendingPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsProcessFinance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsSinglePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereIsTakeMedicine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereNumberRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePatientCompanyRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePaymentMethodSinglePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePharmacyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePharmacyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePriceProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePromotionReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePromotionSimplifiedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePromotionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction wherePromotionValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereRemainingBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereRounding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereRoundingRemainder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSecondServicePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereServiceOtherPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSinglePaymentAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSinglePaymentPaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSinglePaymentPaymentReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatusPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSubTotalPriceBeforeRounding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereSubTotalPriceEmbalage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereTypeCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereTypeDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUseControlScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUserTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $product_id
 * @property string|null $name
 * @property int $quantity
 * @property numeric $price
 * @property numeric $sub_total_price
 * @property string|null $description
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property numeric $discount
 * @property string|null $discount_type
 * @property numeric $discount_value
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionAction withoutTrashed()
 */
	class TransactionAction extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_action_id
 * @property string $transaction_id
 * @property string|null $product_package_id
 * @property string|null $product_id
 * @property int $quantity_real
 * @property int $quantity
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereProductPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereTransactionActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionActionDetail withoutTrashed()
 */
	class TransactionActionDetail extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $description
 * @property string|null $verification_status
 * @property string|null $clinical_status
 * @property string|null $snomed_code
 * @property string|null $onset_datetime
 * @property string $type
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereOnsetDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereSnomedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition whereVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionCondition withoutTrashed()
 */
	class TransactionCondition extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $transaction_detail_id
 * @property string|null $deposit_item_id
 * @property string|null $transaction_recipe_id
 * @property string|null $branch_id
 * @property string|null $user_id
 * @property string $type
 * @property numeric $dosage_doctor
 * @property numeric $doctor_dosage_gram
 * @property int $dosage_drug
 * @property string|null $name
 * @property string|null $product_id
 * @property string|null $product_package_id
 * @property string|null $company_id
 * @property numeric $quantity_real
 * @property numeric $price
 * @property numeric $price_discount
 * @property numeric $price_hpp
 * @property int $quantity
 * @property numeric $discount
 * @property numeric $sub_total_price
 * @property numeric $sub_total_price_hpp
 * @property bool $is_narcotic
 * @property bool $is_free_item
 * @property string|null $user_asign_narcotic_id
 * @property string $type_transaction
 * @property bool $is_outside_pharmacy
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $nurse_id
 * @property string|null $doctor_id
 * @property numeric $incentive_nurse
 * @property numeric $incentive_doctor
 * @property string|null $odontogram_code
 * @property string|null $odontogram_color
 * @property string|null $discount_type
 * @property numeric $discount_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TransactionDetail> $childDetails
 * @property-read int|null $child_details_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $doctor
 * @property-read \App\Models\User|null $nurse
 * @property-read TransactionDetail|null $parentDetail
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @property-read \App\Models\Transaction\TransactionRecipe|null $transactionRecipe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDepositItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDoctorDosageGram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDosageDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereDosageDrug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereIncentiveDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereIncentiveNurse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereIsFreeItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereIsNarcotic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereIsOutsidePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereNurseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereOdontogramCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereOdontogramColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereProductPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereSubTotalPriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereTypeTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereUserAsignNarcoticId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetail withoutTrashed()
 */
	class TransactionDetail extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_detail_id
 * @property string $transaction_id
 * @property string|null $branch_id
 * @property string|null $product_package_id
 * @property string|null $product_id
 * @property int $quantity_real
 * @property int $quantity
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereProductPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereQuantityReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDetailPackage withoutTrashed()
 */
	class TransactionDetailPackage extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string|null $subjective
 * @property string|null $objective
 * @property string|null $assessment
 * @property string|null $plan
 * @property string|null $return_recommendation
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereAssessment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereObjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereReturnRecommendation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereSubjective($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionDiagnosis withoutTrashed()
 */
	class TransactionDiagnosis extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string $icd10_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $type
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Icd\Icd10|null $icd10
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereIcd10Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd10 withoutTrashed()
 */
	class TransactionIcd10 extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string $icd9_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Icd\Icd9|null $icd9
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereIcd9Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionIcd9 withoutTrashed()
 */
	class TransactionIcd9 extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id ID transaksi yang terkait dengan perawat ini
 * @property string|null $nurse_id ID perawat yang terkait dengan transaksi ini
 * @property string|null $nurse_name Nama perawat yang terkait dengan transaksi ini
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $nurse
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereNurseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereNurseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionNurse withoutTrashed()
 */
	class TransactionNurse extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string $payment_method_id
 * @property string|null $description
 * @property float $admin_fee
 * @property float $payment_amount
 * @property float $payment_real
 * @property bool $is_single_payment
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_down_payment
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\PaymentMethod\PaymentMethod|null $paymentMethod
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereAdminFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereIsDownPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereIsSinglePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment wherePaymentReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPayment withoutTrashed()
 */
	class TransactionPayment extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $heart_rate
 * @property string|null $breathing
 * @property string|null $blood_pressure_sistole
 * @property string|null $blood_pressure_diastole
 * @property string|null $body_temperature
 * @property string|null $height
 * @property string|null $weight
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $head_circumference
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereBloodPressureDiastole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereBloodPressureSistole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereBodyTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereBreathing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereHeadCircumference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereHeartRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPhysicalExamination withoutTrashed()
 */
	class TransactionPhysicalExamination extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $description_primary
 * @property string|null $verification_status
 * @property string|null $clinical_status
 * @property string|null $snomed_code
 * @property string|null $onset_datetime
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereDescriptionPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereOnsetDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereSnomedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary whereVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionPrimary withoutTrashed()
 */
	class TransactionPrimary extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string|null $user_name
 * @property string|null $transaction_recipe_id
 * @property string|null $transaction_detail_id
 * @property string $product_id
 * @property string $product_name
 * @property int $quantity
 * @property numeric $price
 * @property numeric $total
 * @property numeric $hpp_average
 * @property numeric $hpp_total
 * @property numeric $profit
 * @property numeric $margin
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @property-read \App\Models\Transaction\TransactionDetail|null $transactionDetail
 * @property-read \App\Models\Transaction\TransactionRecipe|null $transactionRecipe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereHppAverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereHppTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProduct withoutTrashed()
 */
	class TransactionProduct extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $user_id
 * @property string $date
 * @property string|null $description
 * @property string|null $before_photo
 * @property string|null $after_photo
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereAfterPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereBeforePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionProofOfAction withoutTrashed()
 */
	class TransactionProofOfAction extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $medicine_type_id
 * @property string|null $branch_id
 * @property int $numero_recipe
 * @property numeric $price_service_one
 * @property numeric $price_service_other
 * @property string|null $product_id
 * @property int $quantity
 * @property numeric $price
 * @property numeric $price_discount
 * @property numeric $price_hpp
 * @property numeric $sub_total_price
 * @property numeric $sub_total_price_hpp
 * @property string|null $how_to_use_id
 * @property string|null $description
 * @property string|null $route_coding_code
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $notes
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\HowToUse\HowToUse|null $howToUse
 * @property-read \App\Models\MedicineType\MedicineType|null $medicineType
 * @property-read \App\Models\Product\Product|null $product
 * @property-read \App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestDosageRoute|null $routeCodingCode
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction\TransactionDetail> $transactionDetail
 * @property-read int|null $transaction_detail_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereHowToUseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereMedicineTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereNumeroRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe wherePriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe wherePriceServiceOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe wherePriceServiceOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereRouteCodingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereSubTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereSubTotalPriceHpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipe withoutTrashed()
 */
	class TransactionRecipe extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string|null $transaction_recipe_id
 * @property string|null $product_id
 * @property string|null $product_name
 * @property string|null $medicine_type_id
 * @property string|null $medicine_type_name
 * @property int $numero_recipe
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereMedicineTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereMedicineTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereNumeroRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereTransactionRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeReal withoutTrashed()
 */
	class TransactionRecipeReal extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_recipe_real_id
 * @property string|null $transaction_id
 * @property string|null $transaction_detail_id
 * @property string|null $product_id
 * @property string|null $product_name
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereTransactionRecipeRealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionRecipeRealDetail withoutTrashed()
 */
	class TransactionRecipeRealDetail extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string $user_id
 * @property string|null $date
 * @property string|null $hospital
 * @property string|null $doctor_name
 * @property string|null $description
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereDoctorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereHospital($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionReference withoutTrashed()
 */
	class TransactionReference extends \Eloquent {}
}

namespace App\Models\Transaction{
/**
 * @property string $id
 * @property string $transaction_id
 * @property string|null $description_secondary
 * @property string|null $supporting_verification_status
 * @property string|null $supporting_clinical_status
 * @property string|null $supporting_snomed_code
 * @property string|null $supporting_onset_datetime
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereDescriptionSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereSupportingClinicalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereSupportingOnsetDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereSupportingSnomedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereSupportingVerificationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransactionSecondary withoutTrashed()
 */
	class TransactionSecondary extends \Eloquent {}
}

namespace App\Models\Unit{
/**
 * @property string $id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string $name
 * @property string|null $email
 * @property string|null $username
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $profile
 * @property string|null $user_id User Referensi untuk relasi diri sendiri
 * @property string|null $user_type_id
 * @property string|null $company_id
 * @property int $order
 * @property string|null $alternative_contacts Alternative emails/phones for different contexts
 * @property string $type_user Type of user: employee, or patient
 * @property bool $is_head Apakah role ini adalah kepala dari perusahaan atau tidak
 * @property bool $is_active Status aktif dari role ini
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $identity_card
 * @property bool|null $identity_card_mother
 * @property string|null $shift_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\Company> $companies
 * @property-read int|null $companies_count
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\UserCompanyRole> $companyRoles
 * @property-read int|null $company_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\ControlDoctor> $controlDoctors
 * @property-read int|null $control_doctors_count
 * @property-read \App\Models\Hr\EmployeePayroll|null $employeePayroll
 * @property-read \App\Models\Family\Family|null $family
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Family\FamilyMember> $familyMembers
 * @property-read int|null $family_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Leave> $leaves
 * @property-read int|null $leaves_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Patient\Patient|null $patient
 * @property-read \App\Models\Patient\PatientReferralIncentive|null $patientReferralIncentiveReceived
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Patient\PatientReferralIncentive> $patientReferralIncentivesGiven
 * @property-read int|null $patient_referral_incentives_given_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spatie\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Doctor\Doctor|null $roleDoctor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Spatie\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Hr\Shift|null $shift
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\UserControlSchedule> $userControlSchedules
 * @property-read int|null $user_control_schedules_count
 * @property-read \App\Models\User\UserDetail|null $userDetail
 * @property-read \App\Models\User\UserPrice|null $userPrice
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User companyChoice($companyId, $is_head = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User companyRole($roleName, $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User companyWithoutRolePasienAndDokter($companyIds)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlternativeContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdentityCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIdentityCardMother($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTypeUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $product_id
 * @property string|null $description
 * @property string|null $transaction_id
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AllergyMedicine withoutTrashed()
 */
	class AllergyMedicine extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $location_id
 * @property string $days
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property int $max_patients
 * @property bool $is_unlimited
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read mixed $end_time_get
 * @property-read mixed $start_time_get
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereIsUnlimited($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereMaxPatients($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ControlDoctor withoutTrashed()
 */
	class ControlDoctor extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string $role_id
 * @property string|null $role_company_id
 * @property string|null $company_id
 * @property string|null $medical_record_number Nomor rekam medis untuk pasien (bisa kosong untuk non-pasien)
 * @property bool $is_head Apakah role ini adalah kepala dari perusahaan atau tidak
 * @property bool $is_active Status aktif dari role ini
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\Spatie\Role|null $role
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole companyRole($roleName, $companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereIsHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereMedicalRecordNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereRoleCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCompanyRole withoutTrashed()
 */
	class UserCompanyRole extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string|null $transaction_id
 * @property string $user_id
 * @property string|null $date
 * @property string|null $doctor_id
 * @property string|null $location_id
 * @property string|null $description
 * @property array<array-key, mixed>|null $products
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $transaction_arrival_id
 * @property string|null $status
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $doctor
 * @property-read \App\Models\Location\Location|null $location
 * @property-read \App\Models\Transaction\Transaction|null $transaction
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule search($searchTerm)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereTransactionArrivalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserControlSchedule withoutTrashed()
 */
	class UserControlSchedule extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $doctor_id ID dokter, jika pengguna adalah dokter
 * @property string|null $province_code Kode provinsi by one health
 * @property string|null $province
 * @property string|null $city_code Kode kabupaten by one health
 * @property string|null $city
 * @property string|null $district_code Kode kecamatan by one health
 * @property string|null $district
 * @property string|null $sub_district_code Kode kelurahan by one health
 * @property string|null $sub_district
 * @property string|null $postal_code
 * @property string|null $address Alamat lengkap pengguna
 * @property string $country
 * @property string|null $rt Kode RT by one health
 * @property string|null $rw Kode RW by one health
 * @property string $longitude Kode longitude by one health
 * @property string $latitude Kode latitude by one health
 * @property string $altitude Kode altitude by one health
 * @property string|null $ihs_number Nomor IHS untuk pasien (bisa kosong untuk non-pasien)
 * @property string|null $identity_card Foto / path file kartu identitas (KTP, BPJS, dll)
 * @property string|null $blood_group Golongan darah (jika tersedia)
 * @property string|null $administrative_gender Jenis kelamin administratif, mengacu pada terminologi AdministrativeGender
 * @property \Illuminate\Support\Carbon|null $birth_date Tanggal lahir
 * @property string|null $deceased_date Tanggal kematian (jika pasien sudah meninggal)
 * @property string|null $marital_status Status pernikahan sipil, mengacu pada terminologi Marital Status Codes
 * @property string $status Status akun pengguna
 * @property string|null $sip_number Nomor Surat Izin Praktik (hanya untuk dokter)
 * @property string|null $specialization Spesialisasi dokter
 * @property string|null $license_number Nomor Surat Izin Praktik (hanya untuk dokter)
 * @property string $doctor_type Tipe dokter (umum atau spesialis)
 * @property string $type Tipe dokter (in house atau out house)
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property numeric|null $referral_percentage Persentase referral dokter
 * @property-read mixed $identity_card_display
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAdministrativeGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereAltitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDeceasedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDoctorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereIdentityCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereIhsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereProvinceCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereReferralPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereSipNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereSpecialization($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereSubDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereSubDistrictCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withoutTrashed()
 */
	class UserDetail extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $transaction_id ID transaksi yang terkait dengan insentif ini
 * @property numeric|null $amount Jumlah insentif, bisa kosong jika tidak ada insentif
 * @property string|null $month Bulan insentif, bisa kosong jika tidak ada insentif
 * @property string|null $year Tahun insentif, bisa kosong jika tidak ada insentif
 * @property string $status Status perawat dalam transaksi ini
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $transaction_detail_id ID detail transaksi untuk insentif berbasis produk
 * @property string|null $description
 * @property bool $is_generate
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereIsGenerate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereTransactionDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserIncentive withoutTrashed()
 */
	class UserIncentive extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property string|null $insurance_number Nomor asuransi pasien (jika ada)
 * @property string|null $insurance_type Tipe asuransi pasien (jika ada)
 * @property string|null $insurance_company Perusahaan asuransi pasien (jika ada)
 * @property string|null $insurance_expiry_date Tanggal kedaluwarsa asuransi pasien (jika ada)
 * @property string|null $insurance_status Status asuransi pasien (aktif/non-aktif)
 * @property string|null $insurance_card Foto / path file kartu asuransi (jika ada)
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserInsurance withoutTrashed()
 */
	class UserInsurance extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_id
 * @property numeric|null $price_doctor Harga untuk dokter, bisa kosong jika tidak ada harga
 * @property string $type_incentive_doctor Tipe insentif untuk dokter, bisa berupa rupiah atau persen
 * @property string $type_incentive_nurse Tipe insentif untuk perawat/terapis, bisa berupa rupiah atau persen
 * @property string $type_incentive_pharmacy Tipe insentif untuk apoteker, bisa berupa rupiah atau persen
 * @property string $type_incentive_cashier Tipe insentif untuk kasir, bisa berupa rupiah atau persen
 * @property numeric|null $incentive_doctor Incentive untuk dokter, bisa kosong jika tidak ada harga
 * @property numeric|null $incentive_nurse Incentive untuk Perawat / Terapis, bisa kosong jika tidak ada harga
 * @property numeric|null $incentive_pharmacy Incentive untuk Apoteker, bisa kosong jika tidak ada
 * @property numeric|null $incentive_cashier Incentive untuk Kasir, bisa kosong jika tidak ada
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereIncentiveCashier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereIncentiveDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereIncentiveNurse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereIncentivePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice wherePriceDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereTypeIncentiveCashier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereTypeIncentiveDoctor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereTypeIncentiveNurse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereTypeIncentivePharmacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserPrice withoutTrashed()
 */
	class UserPrice extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\UserTypeIncentive> $userTypeIncentives
 * @property-read int|null $user_type_incentives_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserType withoutTrashed()
 */
	class UserType extends \Eloquent {}
}

namespace App\Models\User{
/**
 * @property string $id
 * @property string $user_type_id
 * @property numeric $price_min
 * @property numeric|null $price_max
 * @property numeric $incentive_value
 * @property string $incentive_type
 * @property string|null $description
 * @property bool $is_active
 * @property string|null $company_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company\Company|null $company
 * @property-read mixed $incentive_description
 * @property-read mixed $price_range_description
 * @property-read \App\Models\User\UserType|null $userType
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive byCompany($companyId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive forPrice($price)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereIncentiveType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereIncentiveValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive wherePriceMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive wherePriceMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive whereUserTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserTypeIncentive withoutTrashed()
 */
	class UserTypeIncentive extends \Eloquent {}
}

