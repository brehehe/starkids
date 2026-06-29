<?php

use App\Http\Controllers\Admin\Consultation\ConsultationPrintController;
use App\Http\Controllers\Admin\Prescription\PrescriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Import\ReplaceProductImportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Print\PrintController;
use App\Http\Controllers\Print\PrintControllerNew;
use App\Http\Controllers\QueueController;
use App\Livewire\Admin\Family\AdminFamilyIndex;
use App\Livewire\Admin\Hr\Payroll\AdminHrPayrollAdjustmentIndex;
use App\Livewire\Admin\Hr\Payroll\AdminHrPayrollGenerateIndex;
use App\Livewire\Admin\Logistic\ProductAdjustment\AdminLogisticProductAdjustmentIndex;
use App\Livewire\Admin\Notification\AdminNotificationIndex;
use App\Livewire\Admin\Queue\AdminQueueMonitorIndex;
use App\Livewire\Mobile\Authenticate\AuthenticateLoginIndex;
use App\Livewire\Mobile\Authenticate\AuthenticateRegisterIndex;
use App\Livewire\Mobile\Home\HomeIndex;
use App\Livewire\Mobile\Profile\AccountInformationIndex;
use App\Livewire\Mobile\Profile\ProfileIndex;
use App\Livewire\Mobile\QueueRegister\QueueRegisterCreatePatient;
use App\Livewire\Mobile\QueueRegister\QueueRegisterDetail;
use App\Livewire\Mobile\QueueRegister\QueueRegisterIndex;
use App\Livewire\Queue\QueueIndex;
use App\Livewire\Queue\QueueRegister;
use App\Models\Notification\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['auth'])->group(function () {

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Route::group(['namespace' => 'App\Livewire\Auth'], function () {
    // Add your routes here
    Route::get('login', 'Login\AuthLoginIndex')->name('login');
    Route::get('new-login', 'NewLogin\AuthNewLoginIndex')->name('new-login');
    Route::get('register', 'Register\AuthRegisterIndex')->name('register');
});

// Public routes
Route::group(['namespace' => 'App\Livewire\User'], function () {
    Route::get('/', 'Home\UserHomeIndex')->name('home');
    Route::get('/home', 'Home\UserHomeIndex')->name('user.home');
});

Route::group(['namespace' => 'App\Livewire\Admin', 'prefix' => 'user', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', 'Dashboard\AdminDashboardIndex')->name('user.dashboard');

    Route::group(['namespace' => 'Hr', 'prefix' => 'hr'], function () {
        Route::get('/employee', 'Employee\AdminHrEmployeeIndex')->name('user.hr.employee.index');
        Route::get('/doctor', 'Doctor\AdminHrDoctorIndex')->name('user.hr.doctor.index');
        Route::get('/attendance', 'Attendance\AdminHrAttendanceIndex')->name('user.hr.attendance.index');
        Route::get('/leave', 'Leave\AdminHrLeaveIndex')->name('user.hr.leave.index');

        // Monitoring
        Route::get('/monitor/attendance', 'Monitoring\AdminHrAttendanceMonitorIndex')->name('user.hr.monitor.attendance');
        Route::get('/monitor/leave', 'Monitoring\AdminHrLeaveMonitorIndex')->name('user.hr.monitor.leave');

        // Master Payroll
        Route::get('/master-payroll/component', 'MasterPayroll\AdminHrMasterPayrollComponentIndex')->name('user.hr.master-payroll.component');
        Route::get('/master-payroll/setting', 'MasterPayroll\AdminHrMasterPayrollSettingIndex')->name('user.hr.master-payroll.setting');
        Route::get('/shift', 'Shift\AdminHrShiftIndex')->name('user.hr.shift.index');
        Route::get('/shift-setting', 'Shift\AdminHrShiftSettingIndex')->name('user.hr.shift-setting.index');

        // Payroll Transactional
        Route::prefix('payroll')->group(function () {
            Route::get('/adjustment', AdminHrPayrollAdjustmentIndex::class)->name('user.hr.payroll.adjustment');
            Route::get('/generate', AdminHrPayrollGenerateIndex::class)->name('user.hr.payroll.generate');
        });
    });

    Route::group(['namespace' => 'Registration', 'prefix' => 'registration'], function () {
        Route::get('/new', 'New\AdminRegistrationNewIndex')->name('user.registration.new');
        Route::get('/appointments', 'Appointments\AdminRegistrationAppointmentsIndex')->name('user.registration.appointments');
        // Route::get('/queue', 'Queue\AdminRegistrationQueueIndex')->name('user.registration.queue');
    });

    Route::group(['namespace' => 'Consultation', 'prefix' => 'consultation'], function () {
        Route::get('/patient', 'Patient\AdminConsultationPatientIndex')->name('user.consultation.patient');
        Route::get('/patient/detail/{id}', 'Patient\Detail\AdminConsultationPatientDetailIndex')->name('user.consultation.patient.detail.id');
        Route::get('/patient/detail', 'Patient\Detail\AdminConsultationPatientDetailIndex')->name('user.consultation.patient.detail');
        Route::get('/queue', 'Queue\AdminConsultationQueueIndex')->name('user.consultation.queue');
        Route::get('/consultation', 'Consultation\AdminConsultationConsultationIndex')->name('user.consultation.consultation');
        Route::get('/consultation/detail', 'Consultation\Detail\AdminConsultationConsultationDetailIndex')->name('user.consultation.consultation.detail');
        Route::get('/history', 'History\AdminConsultationHistoryIndex')->name('user.consultation.history');
        Route::get('/claim-insurance', 'ClaimInsurance\AdminConsultationClaimInsuranceIndex')->name('user.consultation.claim-insurance');
        Route::get('/history/detail', 'History\Detail\AdminConsultationHistoryDetailIndex')->name('user.consultation.history.detail');
        Route::get('/date-control', 'DateControl\AdminConsultationDateControlIndex')->name('user.consultation.date-control');
        Route::get('/satusehat', 'SatuSehat\AdminConsultationSatuSehatIndex')->name('user.consultation.satusehat');

        // Print Routes
        Route::get('/referral/print/{transaction_id}', [ConsultationPrintController::class, 'printReferral'])->name('user.consultation.referral.print');
        Route::get('/consent/print/{transaction_id}', [ConsultationPrintController::class, 'printConsent'])->name('user.consultation.consent.print');
    });

    Route::group(['namespace' => 'Receipt', 'prefix' => 'receipt'], function () {
        Route::get('/invoice/{transaction_id}', 'Invoice\AdminReceiptInvoiceIndex')->name('user.receipt.invoice');
        Route::get('/receipt/{transaction_id}', 'Receipt\AdminReceiptReceiptIndex')->name('user.receipt.receipt');
        Route::get('/mail-order/{purchase_order_id}', 'MailOrder\AdminReceiptMailOrderIndex')->name('user.receipt.mail-order');
        Route::get('/recipe/{transaction_id}', 'Recipe\AdminReceiptRecipeIndex')->name('user.receipt.recipe');
    });

    // Prescription routes
    Route::group(['prefix' => 'prescription'], function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('user.prescription.index');
        Route::get('/view/{transaction_id}', [PrescriptionController::class, 'show'])->name('user.prescription.show');
        Route::get('/copy/{transaction_id}', [PrescriptionController::class, 'showCopy'])->name('user.prescription.copy');
        Route::get('/print/{transaction_id}', [PrescriptionController::class, 'print'])->name('user.prescription.print');
        Route::get('/print-copy/{transaction_id}', [PrescriptionController::class, 'printCopy'])->name('user.prescription.print-copy');
    });

    Route::group(['namespace' => 'Purchase', 'prefix' => 'purchase'], function () {
        Route::get('/defecta', 'Defecta\AdminPurchaseDefectaIndex')->name('user.purchase.defecta');
        Route::get('/draft-mail-order', 'Draft\MailOrder\AdminPurchaseDraftMailOrderIndex')->name('user.purchase.draft-mail-order');
        Route::get('/mail-order', 'MailOrder\AdminPurchaseMailOrderIndex')->name('user.purchase.mail-order');
        Route::get('/mail-order/detail', 'MailOrder\Detail\AdminPurchaseMailOrderDetailIndex')->name('user.purchase.mail-order.detail');
        Route::get('/mail-order/create', 'MailOrder\Create\AdminPurchaseMailOrderCreateIndex')->name('user.purchase.mail-order.create');
    });

    Route::group(['namespace' => 'Logistic', 'prefix' => 'logistic'], function () {
        Route::get('/good-come', 'GoodCome\AdminLogisticGoodComeIndex')->name('user.logistic.good-come');
        Route::get('/good-come/detail', 'GoodCome\Detail\AdminLogisticGoodComeDetailIndex')->name('user.logistic.good-come.detail');

        Route::get('/direct-purchase', 'DirectPurchase\AdminLogisticDirectPurchaseIndex')->name('user.logistic.direct-purchase');
        Route::get('/direct-purchase/detail', 'DirectPurchase\Detail\AdminLogisticDirectPurchaseDetailIndex')->name('user.logistic.direct-purchase.detail');
        Route::get('/product-stock', 'ProductStock\AdminLogisticProductStockIndex')->name('user.logistic.product-stock');
        Route::get('/product-adjustment', AdminLogisticProductAdjustmentIndex::class)->name('user.logistic.product-adjustment');
        Route::get('/stock-in', 'StockIn\AdminLogisticStockInIndex')->name('user.logistic.stock-in');
        Route::get('/stock-out', 'StockOut\AdminLogisticStockOutIndex')->name('user.logistic.stock-out');
        Route::get('/import-stock-product', 'ImportStockProduct\AdminLogisticImportStockProductIndex')->name('user.logistic.import-stock-product');
        Route::get('/stock-product', 'StockProduct\AdminLogisticStockProductIndex')->name('user.logistic.stock-product');
        Route::get('/stock-product/detail', 'StockProduct\Detail\AdminLogisticStockProductDetailIndex')->name('user.logistic.stock-product.detail');
        Route::get('/return', 'Return\AdminLogisticReturnIndex')->name('user.purchase.return');
        Route::get('/dead-stock', 'DeadStock\AdminLogisticDeadStockIndex')->name('user.purchase.dead-stock');
        Route::get('/expired-date', 'ExpiredDate\AdminLogisticExpiredDateIndex')->name('user.purchase.expired-date');

        Route::get('/replace-product', 'ReplaceProduct\AdminLogisticReplaceProductIndex')->name('user.purchase.replace-product');
        Route::get('/return/detail', 'Return\Detail\AdminLogisticReturnDetailIndex')->name('user.purchase.return.detail');
        Route::get('/stock-mutation', 'StockMutation\AdminLogisticStockMutationIndex')->name('user.logistic.stock-mutation');
        Route::get('/stock-mutation/detail', 'StockMutation\Detail\AdminLogisticStockMutationDetailIndex')->name('user.logistic.stock-mutation.detail');
    });

    // Excel Import Routes
    Route::group(['prefix' => 'import'], function () {
        Route::post('/replace-product', [ReplaceProductImportController::class, 'import'])->name('user.import.replace-product');
        Route::get('/replace-product/progress/{key}', [ReplaceProductImportController::class, 'getProgress'])->name('user.import.replace-product.progress');
    });

    Route::group(['prefix' => 'pharmacy'], function () {
        Route::group(['namespace' => 'Pharmacy'], function () {
            Route::get('/consultation', 'Consultation\AdminPharmacyConsultationIndex')->name('user.pharmacy.consultation');
            Route::get('/consultation/detail', 'Consultation\Detail\AdminPharmacyConsultationDetailIndex')->name('user.pharmacy.consultation.detail');
            Route::get('/sale', 'Sale\AdminPharmacySaleIndex')->name('user.pharmacy.sale');

            Route::get('/sale/detail', 'Sale\Detail\AdminPharmacySaleDetailIndex')->name('user.pharmacy.sale.detail');
            Route::get('/take-medicine', 'TakeMedicine\AdminPharmacyTakeMedicineIndex')->name('user.pharmacy.take-medicine');
            Route::get('/take-medicine/detail', 'TakeMedicine\Detail\AdminPharmacyTakeMedicineDetailIndex')->name('user.pharmacy.take-medicine.detail');
        });
        Route::group(['namespace' => 'Sale'], function () {
            Route::get('/price', 'Price\AdminSalePriceIndex')->name('user.pharmacy.price');
            Route::get('/product-price', 'ProductPrice\AdminSaleProductPriceIndex')->name('user.pharmacy.product-price');
            if (config('app.salerecipe')) {
                Route::get('/sale/recipe', 'Pos\Recipe\AdminSalePosRecipeIndexNew')->name('user.pharmacy.sale.recipe');
            } else {
                Route::get('/sale/recipe', 'Pos\Recipe\AdminSalePosRecipeIndex')->name('user.pharmacy.sale.recipe');
            }
        });
    });

    Route::group(['namespace' => 'Consultation', 'prefix' => 'sale'], function () {
        Route::get('/claim-insurance', 'ClaimInsurance\AdminConsultationClaimInsuranceIndex')->name('user.sale.claim-insurance');
    });
    Route::group(['namespace' => 'Sale', 'prefix' => 'sale'], function () {
        Route::get('/price', 'Price\AdminSalePriceIndex')->name('user.sale.price');
        Route::get('/product-price', 'ProductPrice\AdminSaleProductPriceIndex')->name('user.sale.product-price');
        Route::get('/pos', 'Pos\AdminSalePosIndex')->name('user.sale.pos');
        Route::get('/pos/detail', 'Pos\Detail\AdminSalePosDetailIndex')->name('user.sale.pos.detail');
        if (config('app.salerecipe')) {
            Route::get('/pos/recipe', 'Pos\Recipe\AdminSalePosRecipeIndexNew')->name('user.sale.pos.recipe');
        } else {
            Route::get('/pos/recipe', 'Pos\Recipe\AdminSalePosRecipeIndex')->name('user.sale.pos.recipe');
        }
        Route::get('/pending', 'Pending\AdminSalePendingIndex')->name('user.sale.pending');
        Route::get('/pending/{transaction_id}/detail', 'Pending\AdminSalePendingDetailIndex')->name('user.sale.pending.detail');
        Route::get('/pending/print/payment/{payment_id}', 'Pending\Print\AdminSalePendingPaymentReceiptIndex')->name('user.sale.pending.print.payment');
        Route::get('/pending/print/transaction-a4/{transaction_id}', 'Pending\Print\AdminSalePendingTransactionA4Index')->name('user.sale.pending.print.transaction-a4');
        Route::get('/report-sale', 'Report\AdminSaleReportIndex')->name('user.sale.report-sale');
        Route::get('/report-sale/detail', 'Report\Detail\AdminSaleReportDetailIndex')->name('user.sale.report-sale.detail');
        Route::get('/report-product-sale', 'ReportProduct\AdminSaleReportProductIndex')->name('user.sale.report-product-sale');
        Route::get('/report-payment', 'ReportPayment\AdminSaleReportPaymentIndex')->name('user.sale.report-payment');
        Route::get('/report-profit-loss', 'ReportProfitLoss\AdminSaleReportProfitLossIndex')->name('user.sale.report-profit-loss');
    });

    Route::group(['namespace' => 'Profile', 'prefix' => 'profile'], function () {
        Route::get('/profile', 'AdminProfileIndex')->name('user.profile.profile');
    });

    Route::group(['prefix' => 'family'], function () {
        Route::get('/', AdminFamilyIndex::class)->name('user.family.index');
    });

    Route::group(['namespace' => 'ChangePassword', 'prefix' => 'change-password'], function () {
        Route::get('/change-password', 'AdminChangePasswordIndex')->name('user.change-password.change-password');
    });

    Route::group(['namespace' => 'Report', 'prefix' => 'report'], function () {
        Route::get('/activity', 'Activity\AdminReportActivityIndex')->name('user.report.activity');
        Route::get('/incentive', 'Incentive\AdminReportIncentiveIndex')->name('user.report.incentive');
        Route::get('/stock', 'Stock\AdminReportStockIndex')->name('user.report.stock');
        Route::get('/in-stock', 'StockIn\AdminReportStockInIndex')->name('user.report.in-stock');
        Route::get('/out-stock', 'StockOut\AdminReportStockOutIndex')->name('user.report.out-stock');
        Route::get('/return-purchase', 'ReturPurchase\AdminReportReturnPurchaseIndex')->name('user.report.purchase.return');
        Route::get('/purchase', 'Purchase\AdminReportPurchaseIndex')->name('user.report.purchase');
        Route::get('/purchase/detail', 'Purchase\Detail\AdminReportPurchaseDetailIndex')->name('user.report.purchase.detail');
        Route::get('/product-purchase', 'PurchaseProduct\AdminReportPurchaseProductIndex')->name('user.report.product.purchase');
        Route::get('/goods-come', 'GoodsCome\AdminReportGoodsComeIndex')->name('user.report.goods-come');
        Route::get('/goods-come/detail', 'GoodsCome\Detail\AdminReportGoodsComeDetailIndex')->name('user.report.goods-come.detail');
        Route::get('/sale', 'Sale\AdminReportSaleIndex')->name('user.report.sale');
        Route::get('/sale/detail', 'Sale\Detail\AdminReportSaleDetailIndex')->name('user.report.sale.detail');
        Route::get('/product-sale', 'SaleProduct\AdminReportSaleProductIndex')->name('user.report.sale.product-sale');
        Route::get('/action', 'Action\AdminReportActionIndex')->name('user.report.action');
        Route::get('/payment', 'Payment\AdminReportPaymentIndex')->name('user.report.payment');
        Route::get('/profit-loss', 'ProfitLoss\AdminReportProfitLossIndex')->name('user.report.profit.loss');
        Route::get('/dead-stock', 'DeadStock\AdminReportDeadStockIndex')->name('user.report.dead-stock');
        Route::get('/opname-stock', 'StockOpname\AdminReportStockOpnameIndex')->name('user.report.opname-stock');
        Route::get('/opname-stock/detail', 'StockOpname\Detail\AdminReportStockOpnameDetailIndex')->name('user.report.opname-stock.detail');
        Route::get('/product-stock-opname', 'StockOpnameProduct\AdminReportStockOpnameProductIndex')->name('user.report.product-stock-opname');
        Route::get('/type-recipe', 'TypeRecipe\AdminReportTypeRecipeIndex')->name('user.report.type-recipe');
        Route::get('/odontogram', 'Odontogram\AdminReportOdontogramIndex')->name('user.report.odontogram');
        Route::get('/doctor-patient', 'DoctorPatient\AdminReportDoctorPatientIndex')->name('user.report.doctor-patient');
        Route::get('/polyclinic', 'Polyclinic\AdminReportPolyclinicIndex')->name('user.report.polyclinic');
        // Route::get('/sale/detail', 'Report\Detail\AdminSaleReportDetailIndex')->name('user.report.sale.detail');
        // Route::get('/product-sale', 'ReportProduct\AdminSaleReportProductIndex')->name('user.report.product.sale');
        // Route::get('/payment', 'ReportPayment\AdminSaleReportPaymentIndex')->name('user.report.payment');
        // Route::get('/profit-loss', 'ReportProfitLoss\AdminSaleReportProfitLossIndex')->name('user.report.profit.loss');
    });

    Route::group(['namespace' => 'Finance', 'prefix' => 'finance'], function () {
        Route::get('/cost', 'Cost\AdminFinanceCostIndex')->name('user.finance.cost');
        Route::get('/cost/detail', 'Cost\Detail\AdminFinanceCostDetailIndex')->name('user.finance.cost.detail');
        Route::get('/finance', 'Finance\AdminFinanceFinanceIndex')->name('user.finance.finance');
        Route::get('/finance/detail', 'Finance\Detail\AdminFinanceFinanceDetailIndex')->name('user.finance.finance.detail');
        Route::get('/dead-stock', 'DeadStock\AdminFinanceDeadStockIndex')->name('user.finance.dead-stock');
        Route::get('/dead-stock/detail', 'DeadStock\Detail\AdminFinanceDeadStockDetailIndex')->name('user.finance.dead-stock.detail');
        Route::get('/stock-opname', 'StockOpname\AdminFinanceStockOpnameIndex')->name('user.finance.stock-opname');
        Route::get('/stock-opname/detail', 'StockOpname\Detail\AdminFinanceStockOpnameDetailIndex')->name('user.finance.stock-opname.detail');
        Route::get('/purchase', 'Purchase\AdminFinancePurchaseIndex')->name('user.finance.purchase');
        Route::get('/purchase/detail', 'Purchase\Detail\AdminFinancePurchaseDetailIndex')->name('user.finance.purchase.detail');
        Route::get('/sale', 'Sale\AdminFinanceSaleIndex')->name('user.finance.sale');
        Route::get('/sale/detail', 'Sale\Detail\AdminFinanceSaleDetailIndex')->name('user.finance.sale.detail');
        Route::get('/balance-sheet', 'BalanceSheet\AdminFinanceBalanceSheetIndex')->name('user.finance.balance-sheet');
        Route::get('/profit-loss', 'ProfitLoss\AdminFinanceProfitLossIndex')->name('user.finance.profit-loss');
        Route::get('/cash-flow', 'CashFlow\AdminFinanceCashFlowIndex')->name('user.finance.cash-flow');
        Route::get('/ledger', 'Ledger\AdminFinanceLedgerIndex')->name('user.finance.ledger');
        Route::get('/journal', 'Journal\AdminFinanceJournalIndex')->name('user.finance.journal');
        Route::get('/general-journal', 'GeneralJournal\AdminFinanceGeneralJournalIndex')->name('user.finance.general-journal');
        Route::get('/general-journal/detail', 'GeneralJournal\Detail\AdminFinanceGeneralJournalDetailIndex')->name('user.finance.general-journal.detail');
        Route::get('/adjustment-journal', 'AdjustmentJournal\AdminFinanceAdjustmentJournalIndex')->name('user.finance.adjustment-journal');
        Route::get('/adjustment-journal/detail', 'AdjustmentJournal\Detail\AdminFinanceAdjustmentJournalDetailIndex')->name('user.finance.adjustment-journal.detail');
    });

    Route::group(['namespace' => 'Master', 'prefix' => 'master'], function () {
        Route::group(['namespace' => 'Product', 'prefix' => 'product'], function () {
            Route::get('/detail', 'Detail\AdminMasterProductDetailIndex')->name('user.master.product.detail');
            Route::get('/detail/data', 'Detail\AdminMasterProductDetailData')->name('user.master.product.detail.data');
            Route::get('/package', 'Package\AdminMasterProductPackageIndex')->name('user.master.product.package');
            Route::get('/package/data', 'Package\AdminMasterProductPackageData')->name('user.master.product.package.data');
            Route::get('/category', 'Category\AdminMasterProductCategoryIndex')->name('user.master.product.category');
            Route::get('/factory', 'Factory\AdminMasterProductFactoryIndex')->name('user.master.product.factory');
            Route::get('/rack', 'Rack\AdminMasterProductRackIndex')->name('user.master.product.rack');
            Route::get('/unit', 'Unit\AdminMasterProductUnitIndex')->name('user.master.product.unit');
        });

        Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
            Route::get('/account', 'Account\AdminMasterAccountAccountIndex')->name('user.master.account.account');
            Route::get('/category-account', 'CategoryAccount\AdminMasterAccountCategoryAccountIndex')->name('user.master.account.category-account');
        });
        Route::get('/recipe', 'Recipe\AdminMasterRecipeIndex')->name('user.master.recipe');
        Route::get('/insurance', 'Insurance\AdminMasterInsuranceIndex')->name('user.master.insurance');
        Route::get('/how-to-use', 'HowToUse\AdminMasterHowToUseIndex')->name('user.master.how-to-use');
        Route::get('/recipe/detail', 'Recipe\Detail\AdminMasterRecipeDetailIndex')->name('user.master.recipe.detail');
        Route::get('/supplier', 'Supplier\AdminMasterSupplierIndex')->name('user.master.supplier');
        Route::get('/role', 'Role\AdminMasterRoleIndex')->name('user.master.role');
        Route::get('/user', 'User\AdminMasterUserIndex')->name('user.master.user');
        Route::get('/doctor', 'Doctor\AdminMasterDoctorIndex')->name('user.master.doctor');
        Route::get('/patient', 'Patient\AdminMasterPatientIndex')->name('user.master.patient');
        Route::get('/user-type/user-type', 'UserType\AdminMasterUserTypeIndex')->name('user.master.user-type');
        Route::get('/user-type/incentive', 'UserType\Incentive\AdminMasterUserTypeIncentiveIndex')->name('user.master.user-type.incentive');
        Route::get('/poly', 'Poly\AdminMasterPolyIndex')->name('user.master.poly');
        Route::get('/icd', 'Icd\AdminMasterIcdIndex')->name('user.master.icd');
        Route::get('/medicine-type', 'MedicineType\AdminMasterMedicineTypeIndex')->name('user.master.medicine-type');
        Route::get('/payment-method', 'PaymentMethod\AdminMasterPaymentMethodIndex')->name('user.master.payment-method');
        Route::get('/print', 'Printer\AdminMasterPrinterIndex')->name('user.master.print');

        // Deposit routes
        // Route::group(['namespace' => 'Deposit', 'prefix' => 'deposit'], function () {
        //     Route::get('/detail', 'Detail\AdminMasterDepositDetailIndex')->name('user.master.deposit.detail');
        // });

        Route::get('/service-month', 'ServiceMonth\AdminMasterServiceMonthIndex')->name('user.master.service-month');
        Route::get('/doctor-control', 'DoctorControl\AdminMasterDoctorControlIndex')->name('user.master.doctor-control');
        Route::get('/action', 'Action\AdminMasterActionIndex')->name('user.master.action');
        Route::get('/service', 'Service\AdminMasterServiceIndex')->name('user.master.service');
        Route::get('/discount', 'Discount\AdminMasterDiscountIndex')->name('user.master.discount');
        Route::get('/company', 'Company\AdminMasterCompanyIndex')->name('user.master.company');
        Route::get('/company/detail', 'Company\Detail\AdminMasterCompanyDetailIndex')->name('user.master.company.detail');
        Route::get('/setting', 'Setting\AdminMasterSettingIndex')->name('user.master.setting');

        Route::get('/deposit', 'Deposit\AdminMasterDepositIndex')->name('user.master.deposit');
        Route::get('/deposit/create', 'Deposit\Detail\AdminMasterDepositDetailIndex')->name('user.master.deposit.create');
        Route::get('/deposit/detail/{id}', 'Deposit\Detail\AdminMasterDepositDetailIndex')->name('user.master.deposit.detail');

        // Article Routes
        Route::group(['namespace' => 'Article', 'prefix' => 'article'], function () {
            Route::get('/category', 'Category\AdminMasterArticleCategoryIndex')->name('user.master.article.category');
            Route::get('/', 'Article\AdminMasterArticleIndex')->name('user.master.article.index');
            Route::get('/create', 'Article\Create\AdminMasterArticleCreateIndex')->name('user.master.article.create');
            Route::get('/edit/{id}', 'Article\Create\AdminMasterArticleCreateIndex')->name('user.master.article.edit');
        });

        // Banner
        Route::get('/banner', 'Banner\AdminMasterBannerIndex')->name('user.master.banner.index');
    });

    // Promotion Management Routes
    Route::group(['namespace' => 'Promotion', 'prefix' => 'promotion'], function () {
        // Dashboard & Analytics
        Route::get('/dashboard', 'Dashboard\AdminPromotionDashboardIndex')->name('user.promotion.dashboard');

        // Promotion CRUD
        Route::get('/', 'AdminPromotionIndex')->name('admin.promotion.index');
        Route::get('/create', 'Create\AdminPromotionCreateIndex')->name('user.promotion.create');
        Route::get('/edit/{id}', 'Create\AdminPromotionCreateIndex')->name('user.promotion.edit');
    });

    // Notification Routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('user.notifications.index');
        Route::get('/list', AdminNotificationIndex::class)->name('user.notifications.list'); // New Route
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('user.notifications.read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('user.notifications.mark-all-read');
    });

    // System Update Routes
    Route::group(['namespace' => 'SystemUpdate', 'prefix' => 'system-updates'], function () {
        Route::get('/', 'AdminSystemUpdateIndex')->name('admin.system-update.index');
        Route::get('/detail', 'AdminSystemUpdateDetail')->name('admin.system-update.detail');
    });
});

// if (config('app.env') === 'local' || config('app.env') === 'development') {
// }
Route::redirect('', '/user');

Route::get('logout', function () {
    if (Auth::check()) {
        $user = User::find(auth()->user()->id);
        $user->update([
            'company_id' => null,
        ]);
    }
    auth()->logout();

    return redirect()->route('login');
})->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/panggil-berikutnya', [AdminController::class, 'callNext'])->name('admin.call-next');
    Route::patch('/antrian/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
});

// RAHMIE
Route::prefix('/prototype/antrian')->group(function () {
    Route::get('/', [QueueController::class, 'index'])->name('queue.index');
    Route::get('/daftar', [QueueController::class, 'create'])->name('queue.create');
    Route::post('/', [QueueController::class, 'store'])->name('queue.store');
    Route::get('/data', [QueueController::class, 'getQueueData'])->name('queue.data');
});

Route::prefix('/antrian')->group(function () {
    Route::get('/', QueueIndex::class)->name('queue');
    Route::get('/daftar', QueueRegister::class)->name('queue.register');
    Route::get('/monitor', AdminQueueMonitorIndex::class)->name('queue.monitor');
});

Route::get('/print/invoice/{id}', [PrintController::class, 'invoice'])->name('print.invoice');
Route::get('/print/invoice-total/{id}', [PrintController::class, 'invoiceTotal'])->name('print.invoice-total');

Route::get('/print/invoice-sale', [PrintControllerNew::class, 'invoiceSale'])->name('print.invoice.sale');

Route::get('/print/invoice-print', [PrintControllerNew::class, 'invoicePrint'])->name('print.invoice.print');

Route::get('/printer/scan', function () {
    $response = Http::get('http://127.0.0.1:5054/scan');

    return $response->json(); // tampilkan daftar printer
});

// 2. Pilih printer
Route::post('/printer/select', function () {
    request()->validate([
        'printer_name' => 'required|string',
    ]);

    $response = Http::post('http://127.0.0.1:5054/select', [
        'printer_name' => request('printer_name'),
    ]);

    return $response->json();
});

// 3. Print struk
Route::post('/printer/print', function () {
    $response = Http::post('http://127.0.0.1:5054/print', [
        'store_name' => 'Starkids Medical Center',
        'store_info' => 'Jl. Soekarno Hatta No. 1 - Surabaya',
        'info' => [
            ['label' => 'No. Invoice', 'value' => 'INV-001'],
            ['label' => 'Tanggal', 'value' => now()->format('d/m/Y')],
        ],
        'items' => [
            ['name' => 'Paracetamol', 'total' => '10.000'],
            ['name' => 'Vitamin C', 'total' => '15.000'],
        ],
        'summary' => [
            ['label' => 'Subtotal', 'value' => '25.000'],
            ['label' => 'TOTAL', 'value' => '25.000'],
        ],
        'footer' => 'Terima kasih atas kunjungan Anda!',
    ]);

    return $response->json();
});

Route::post('/proxy/select', function (Request $request) {
    return Http::withOptions(['verify' => false]) // ignore self-signed
        ->post('https://127.0.0.1:5054/select', $request->all())
        ->json();
});

Route::get('/check-time', function () {
    return ini_get('max_execution_time');
});

Route::prefix('/mobile')->group(function () {
    Route::get('/', AuthenticateLoginIndex::class)->name('mobile.login');
    Route::get('/registrasi', AuthenticateRegisterIndex::class)->name('mobile.register');

    Route::middleware('authenticate-mobile')->group(function () {
        // Home
        Route::get('/beranda', HomeIndex::class)->name('mobile.home');

        // profile
        Route::prefix('/profil')->group(function () {
            Route::get('/', ProfileIndex::class)->name('mobile.profile');
            Route::get('/akun', AccountInformationIndex::class)->name('mobile.profile-account');
        });

        // Queue
        Route::prefix('/antrian')->group(function () {
            Route::get('/', QueueRegisterIndex::class)->name('mobile.queue.register');
            Route::get('/detail/{id}', QueueRegisterDetail::class)->name('mobile.queue.register.detail');
            Route::get('/tambah-pasien', QueueRegisterCreatePatient::class)->name('mobile.queue.register.create-patient');
        });
    });
});

Route::get('/offline', function () {
    return view('errors.offline');
});
