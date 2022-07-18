# Contributing

Contributions are welcome and will be fully credited.

Contributing are accepted via Merge Requests on [the official repository on Gitlab](https://gitlab.com/ludo237/laravel-traits)

## Things you could do

If you want to contribute but do not know where to start, this list provides some starting points:

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

We leverage Docker to make the process easy as possible. In particular, we use a dedicated [DockerFile](./docker/Dockerfile)
to build a ready to use container for development.

- Install Docker on your OS
- Change directory to this repository
- Type `docker-compose up -d --build`
- Wait until the container is ready
- Once the container is up you can interact with it like a normal docker container
- When you are done, type `docker-compose down` and `docker-compose rm`

## Happy Coding!
