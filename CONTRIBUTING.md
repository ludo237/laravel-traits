# Contributing

Contributions are welcome and will be fully credited.

Contributing are accepted via Merge Requests on [the official repository on Gitlab](https://gitlab.com/ludo237/laravel-eoquent-traits)

## Things you could do

If you want to contribute but do not know where to start, this kist provides some starting points:

- More Traits
- More tests
- Better documentation

## Pull Requests

- **Add Tests!** - Your patch won't be accepted if it does not have tests.

- **Document any change in behaviour** - Make sure the `readme.md` and any other relevant documentation are kept up to date.

- **Consider our release cycle** - We try to follow [SemVer v2](http://semver.org). Randomly breaking public APIs is not an option.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make multiple intermediate commits while developing, please [squash them](https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.

## Set up the environment

We leverage Docker to make the process easy as possible. In particular we use [Laradock](https://laradock.io/)
to create the development environment in few minutes:

- Clone Laradock submodule:
    - First Time: `git submodule update --init --recursive`
    - Update:  `git submodule update --recursive --remote`
- Copy `.laradock.env` inside `laradadock/.env` 
- Change the directory in Laradock
- Type `docker-compose up -d --build workspace` that's the only container you need
- Once the container is created you can interact with it like a normal docker container
- When you are done, inside Laradock directory, type `docker-compose down` and `docker-compose rm`

## Happy Coding!