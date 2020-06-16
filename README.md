![Meet Chirp, a free Twitter activity tracker](https://d1srrlgsf6kxjv.cloudfront.net/img/banner.jpg)

# Chirp

[Chirp](https://chirp.benjamincrozat.com) is a Laravel based app running on AWS Lambda. It also uses RDS, SQS and DynamoDB. Hope you'll be able to learn something from it. Also, I'm always thrilled to receive good critisism and PRs.

## Table of contents

- [Development](#development)
- [Testing](#testing)
- [Deployment](#deployment)

## Development

Run the project locally on whatever environment you prefer. This shouldn't be enforced IMO.

```bash
composer install

cp .env.example .env

php artisan key:generate
php artisan migrate

yarn
yarn dev
```

## Testing

Few notes about my testing strategy:
- The "sign in with Twitter" button on the home page is tested with Dusk;
- Twitter's API isn't mocked. I can't be confident about Chirp's stability if I can't hit the real stuff. To avoid rate limit errors, I just cache the responses.

```bash
composer test
```

## Deployment

```bash
cp .env.production.example .env.production

make
```

## License

MIT
