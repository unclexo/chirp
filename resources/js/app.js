import * as Sentry from '@sentry/browser'

Sentry.init({ dsn: process.env.MIX_ALGOLIA_APP_ID })
