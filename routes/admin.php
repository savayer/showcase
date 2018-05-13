<?php

// Backpack\CRUD: Define the resources for the entities you want to CRUD.
CRUD::resource('article', 'ArticleCrudController');
CRUD::resource('teaser', 'TeaserCrudController');
CRUD::resource('sites', 'SitesCrudController');