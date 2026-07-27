<?php

namespace Tests\Unit;

use Tests\TestCase;

class UrlSchemeTest extends TestCase
{
    public function test_url_scheme_is_forced_to_https(): void
    {
        $url = route('user.consultation.consultation.detail');

        $this->assertStringStartsWith('https://', $url);
    }
}
