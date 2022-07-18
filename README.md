[![pipeline status](https://gitlab.com/ludo237/laravel-traits/badges/master/pipeline.svg)](https://gitlab.com/ludo237/laravel-traits/commits/master)
[![coverage report](https://gitlab.com/ludo237/laravel-traits/badges/master/coverage.svg)](https://gitlab.com/ludo237/laravel-traits/commits/master)

# Laravel Traits

A set of useful traits for Laravel.

## Why

Laravel is a great framework and Eloquent is a piece of art in terms of ActiveRecord ORM *but* it lacks some useful quirks and features that I decided to integrated trough a set of Traits.

## What is a trait?

In PHP A trait is a a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies. The semantics of the combination of Traits and classes is defined in a way which reduces complexity,and avoids the typical problems associated with multiple inheritance and Mixins. [Source](https://www.php.net/manual/en/language.oop5.traits.php)

## How to use this package

EZPZ: Grab it from composer `composer require ludo237/laravel-traits` and it's done. Now you can use the traits inside your eloquent models or wherever you needs them

## What is included

With time things can change current traits are:

- `Bannable` inject logic into models to interact with a `banned_at` column.
- `CanBeActivate` add logic to a model in order to activate/deactivate it using a timestamp column
- `ExposeTableProperties` it allows the model to expose publicly the table name, the primary key name and his type.
- `HasSlug` automatically creates the logic behind a `slug` column for your model.
- `HasUuid` like HasSlug but for UUID.
- `InteractsWithApi` automatically set the api_key for the current model following Laravel standards.
- `OwnedByUser` Automatically set the current model as owned by the User model
- `Benchmarkable` Start/Stop a timer to benchmark your Artisan Commands

## How to Contribute

Please see [the contribute file](CONTRIBUTING.md) for more information
