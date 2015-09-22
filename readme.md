# Payme v.1.0

With this micro app you can be paid online! Everything is customizable and the default payment gateway is BrainTree. BrainTree has a unique offer for the first $50.000 (they won't charge you a penny) so I think that this a very good offer especially for startups.

### What this app can do for you

This app can generate unique payment links that auto expire after 48 hours. Those links are safe and unique, you just send your clients a link and you can be paid, just like that. In order to create links there is a back-end User Interface that can be used under the url “/adcp” so you can create/edit/delete payment links as well as users. After each payment you are notified by Email and Slack notifications!

The UI is mobile friendly, so it can be used by mobile phones as well!

### Clef integration for 2way Authentication login!

Clef is a cool way for 2way authentication with a mobile phone. To get an idea visit their official website at clef.io. Your client can login with clef and immediately redirected to his link without typing anything. Super safe and super cool :-)

### Tools used to create Payme

- Laravel 5.1 PHP Framework
- Bootstrap 3.0
- BrainTree API
- Clef
- Bugsnag for debugging
- Composer
- LAMP

### Installation Instructions

1. Move a copy of this repository to your server
2. Install dependencies with Composer
3. Create accounts at clef.io and braintreepayments.com
4. Create a .env file on your server and on your Development machine. Use the .env.example file as an example.
5. Create a slack.io account, add an Incoming web hook integration to a channel and you're good to go!
6. Setup your bugsnag.io account, it will help you identify bugs/errors while happening.

It's highly recommended to use SSL on the domain that will host this app. Encryption is always good, especially for such services.

### Extensibility

With a little effort and if you know how to use the Laravel Framework, you can swap Braintree with any other payment gateway.

### LICENCE
The MIT License (MIT). Please see License File for more information.