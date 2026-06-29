<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('admin.hr.master-payroll.admin-hr-master-payroll-component-index')
        ->assertStatus(200);
});
