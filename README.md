# Laravel Eloquent Traits

A set of useful traits for Eloquent ORM.

## Why

Laravel is a great framework and Eloquent is a piece of art in terms of ActiveRecord ORM *but* it lacks some useful quirks and features that I decided to integrated trough a set of Traits.

## What is a trait?

In PHP A trait is a a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies. The semantics of the combination of Traits and classes is defined in a way which reduces complexity,and avoids the typical problems associated with multiple inheritance and Mixins. [Source](https://www.php.net/manual/en/language.oop5.traits.php)

## How to use this package

EZPZ: Grab it from composer `composer require ludo237/laravel-eloquent-traits` and it's done. Now you can use the traits inside your eloquent models

## What is included

With time things can change, but for v1.x the basic traits will be:

- `ExposeTableProperties` it allows the model to expose publicy the table name, the primary key name and his type.

- `HasSlug` automatically creates the logic behind a `slug` column for your model

- `HasUuid` like HasSlug but for UUID

- `OwnedByUser` this is a bit tricky, basically if you use this Trait the eloquent model will automatically be bound to an User model *still WIP*

## How to Contribute

Please see [the contribute file](CONTRIBUTING.md) for more information