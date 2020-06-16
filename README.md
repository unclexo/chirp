# Chirp

- [Development](#development)
- [Testing](#testing)
- [Deployment](#deployment)

[Chirp](https://chirp.benjamincrozat.com) is a Laravel app running on AWS Lambda. It also uses RDS, SQS and DynamoDB. Hope you'll be able to learn something from it. Also, I'm always thrilled to receive good critisism and PRs.

## Development

Run the project locally on whatever environment you prefer. This shouldn't be enforced IMO.

```bash
composer install
```

```bash
php artisan migrate
```

```bash
yarn && yarn dev
```

## Testing

Few notes about my testing strategy:
- The "sign in with Twitter" button on the home page is tested with Dusk;
- Twitter's API isn't mocked. I can't be confident about Chirp's stability if I can't hit the real API. To avoid rate limit errors, I just cache the API's responses.

```bash
composer test
```

## Deployment

```bash
make
```

## License

MIT
