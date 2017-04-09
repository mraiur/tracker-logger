<?php
// Routes
$app->get('/', App\Action\HomeAction::class)
	->setName('homepage');
$app->post('/track/{log_type}', \App\Action\TrackAction::class);
$app->get('/user/{username}[/]', App\Action\ViewUserAction::class);
$app->get('/user/{username}/{start_date}[/{end_date}]', App\Action\ViewUserAction::class);
