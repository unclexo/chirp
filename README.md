# Chirp

- [Development](#development)
- [Testing](#testing)
- [Deployment](#deployment)

Chirp is a Laravel app running on AWS Lambda. It also uses RDS, SQS and DynamoDB. Hope you'll be able to learn something from it. Also, I'm always thrilled to receive good critisism and PRs.

## Development

Run the project locally on whatever environment you prefer.

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

```bash
composer test
```

## Deployment

```bash
make
```

## License
