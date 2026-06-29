<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('admin.hr.master-payroll.admin-hr-master-payroll-setting-index')
        ->assertStatus(200);
});
