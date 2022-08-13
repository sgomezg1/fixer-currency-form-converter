# fixer-currency-form-converter
Currency converter contact form working with fixer API

We should modify some values to do this working: These are the paths where we should change some values like YOU-FROM-ADDRESS, things like that. Here we go.

/src/credentials: You must change smtp-domain, smtp-user, smtp-password and api-key keys with your own data.
/src/sendEmail.php: In send function, you should replace YOUR-FROM-EMAIL, FROM-NAME, RECIPIENT-ADDRESS and RECIPIENT-NAME keys with your own data.

This will make work this plugin without any problem.

Credits to https://fixer.io API. This is the implemented API to get the rates and currency conversions. You can create an API KEY with 100 requests for testing or buy one of their plans to do more requests and receive some benefits.

Thank you.
