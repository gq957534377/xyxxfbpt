<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',function (){
	return view('admin.index.index');
});

Route::get('index',function (){
    return view('admin.index.index');
});

Route::get('/profile',function (){
    return view('admin.pages.profile');
});

Route::get('/timeline',function (){
    return view('admin.pages.timeline');
});

Route::get('/invoice',function (){
    return view('admin.pages.invoice');
});

Route::get('/contact',function (){
    return view('admin.pages.contact');
});


Route::get('/login',function (){
    return view('admin.login');
});

Route::get('/register',function (){
    return view('admin.register');
});

Route::get('/lock',function (){
    return view('admin.lock');
});


Route::get('/recoverpw',function (){
    return view('admin.recoverpw');
});

Route::get('/blank',function (){
    return view('admin.pages.blank');
});

Route::get('/404_alt',function (){
    return view('admin.pages.404');
});

Route::get('/404',function (){
    return view('admin.errors.404');
});

Route::get('/500',function (){
    return view('admin.errors.500');
});


Route::get('/googlemap',function (){
    return view('admin.maps.googlemap');
});

Route::get('/vectormap',function (){
    return view('admin.maps.vectormap');
});

Route::get('/inbox',function (){
    return view('admin.mail.inbox');
});

Route::get('/compose',function (){
    return view('admin.mail.compose');
});

Route::get('/read',function (){
    return view('admin.mail.read');
});

Route::get('/templates',function (){
    return view('admin.mail.templates');
});

Route::get('/emailaction',function (){
    return view('admin.mail.action');
});

Route::get('/emailalert',function (){
    return view('admin.mail.alert');
});

Route::get('/emailbilling',function (){
    return view('admin.mail.billing');
});






Route::get('typography',function (){
    return view('admin.interface.typography');
});

Route::get('buttons',function (){
    return view('admin.interface.buttons');
});

Route::get('icons',function (){
    return view('admin.interface.icons');
});

Route::get('panels',function (){
    return view('admin.interface.panels');
});

Route::get('tabs',function (){
    return view('admin.interface.tabs');
});

Route::get('modals',function (){
    return view('admin.interface.modals');
});

Route::get('elements',function (){
    return view('admin.interface.elements');
});

Route::get('progressBars',function (){
    return view('admin.interface.progressBars');
});

Route::get('notifications',function (){
    return view('admin.interface.notifications');
});

Route::get('alert',function (){
    return view('admin.interface.alert');
});

//---------------分割线-----------------

Route::get('grid',function (){
    return view('admin.components.grid');
});

Route::get('portlets',function (){
    return view('admin.components.portlets');
});

Route::get('widgets',function (){
    return view('admin.components.widgets');
});

Route::get('nestable',function (){
    return view('admin.components.nestable');
});

Route::get('calendar',function (){
    return view('admin.components.calendar');
});

Route::get('rangSlider',function (){
    return view('admin.components.rangSlider');
});

//---------------分割线-----------------

Route::get('advanced',function (){
    return view('admin.forms.advanced');
});

Route::get('code',function (){
    return view('admin.forms.code');
});

Route::get('crop',function (){
    return view('admin.forms.crop');
});

Route::get('editable',function (){
    return view('admin.forms.editable');
});

Route::get('editor',function (){
    return view('admin.forms.editor');
});

Route::get('formElements',function (){
    return view('admin.forms.formElements');
});

Route::get('upload',function (){
    return view('admin.forms.upload');
});

Route::get('validation',function (){
    return view('admin.forms.validation');
});

Route::get('wizard',function (){
    return view('admin.forms.wizard');
});

//---------------分割线-----------------

Route::get('basic',function (){
    return view('admin.tables.basic');
});

Route::get('responsive',function (){
    return view('admin.tables.responsive');
});

Route::get('tabledit',function (){
    return view('admin.tables.tabledit');
});
