<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('admin.hr.monitoring.admin-hr-leave-monitor-index')
        ->assertStatus(200);
});
