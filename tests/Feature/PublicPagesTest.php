<?php

test('home page is accessible', function () {
    $response = $this->get('/');

    $response->assertSuccessful();
    $response->assertSee('Don\'t bin it, repair it!', false);
});

test('more information page is accessible', function () {
    $response = $this->get(route('more-information'));

    $response->assertSuccessful();
    $response->assertSee('More Information');
});

test('policies page is accessible', function () {
    $response = $this->get(route('policies'));

    $response->assertSuccessful();
    $response->assertSee('Our Policies');
    $response->assertSee('Privacy Policy');
    $response->assertSee('Health & Safety Policy');
    $response->assertSee('Volunteer Policy');
});

test('repair disclaimer page is accessible', function () {
    $response = $this->get(route('repair-disclaimer'));

    $response->assertSuccessful();
    $response->assertSee('Repair Disclaimer');
    $response->assertSee('No Guarantee of Repair');
});

test('contact page is accessible', function () {
    $response = $this->get(route('contact'));

    $response->assertSuccessful();
    $response->assertSee('Contact Us');
    $response->assertSee('Get In Touch');
});
