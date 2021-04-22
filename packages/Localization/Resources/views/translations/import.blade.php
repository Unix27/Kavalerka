@extends('admin::layouts.master')



@section('content')

    <p>Warning, translations are not visible until they are exported back to the app/lang file, using <code>php
            artisan translation:export</code> command or publish button.</p>
    <div class="alert alert-success success-import" style="display:none;">
        <p>Done importing, processed <strong class="counter">N</strong> items! Reload this page to refresh
            the
            groups!</p>
    </div>
    <div class="alert alert-success success-find" style="display:none;">
        <p>Done searching for translations, found <strong class="counter">N</strong> items!</p>
    </div>
    <div class="alert alert-success success-publish-all" style="display:none;">
        <p>Done publishing the translations for all group!</p>
    </div>
    <?php if(Session::has('successPublish')) : ?>
    <div class="alert alert-info">
        <?php echo Session::get('successPublish'); ?>
    </div>
    <?php endif; ?>
    <p>
    <?php if(!isset($group)) : ?>
    <form class="form-import" method="POST" action="{{route('admin.localization.manager.postimport')}}"
          data-remote="true" role="form">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <select name="replace" class="form-control">
                        <option value="0">Append new translations</option>
                        <option value="1">Replace existing translations</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success btn-block" data-disable-with="Loading..">
                        Import
                        groups
                    </button>
                </div>
            </div>
        </div>
    </form>
    <form class="form-find" method="POST" action="{{route('admin.localization.manager.postfind')}}"
          data-remote="true" role="form"
          data-confirm="Are you sure you want to scan you app folder? All found translation keys will be added to the database.">
        <div class="form-group">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <button type="submit" class="btn btn-info" data-disable-with="Searching..">Find translations in
                files
            </button>
        </div>
    </form>
    <?php endif; ?>

    <fieldset>
        <legend>Export all translations</legend>
        <form class="form-inline form-publish-all" method="POST"
              action="{{route('admin.localization.manager.postpublish')}}" data-remote="true" role="form"
              data-confirm="Are you sure you want to publish all translations group? This will overwrite existing language files.">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <button type="submit" class="btn btn-primary" data-disable-with="Publishing..">Publish all
            </button>
        </form>
    </fieldset>

@endsection
