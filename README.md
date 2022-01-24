# Elidrissidev_Api2BasicAuth

This is a Magento 1.9/[OpenMage](https://github.com/openmage/magento-lts) extension that will add support for [HTTP Basic Authentication](https://datatracker.ietf.org/doc/html/rfc7617) in `Api2` by introducing a new concept of "REST Users", which unlike the built-in OAuth adapter, doesn't require any human interaction and can be used to authenticate scripts and backends.

## Installation

1. Download the latest release and unpack it.

2. Copy the `app` folder to the root of your magento store (choose the option to merge it with the existing content if prompted).

3. Go to `System / Cache Management` and click "Flush Magento Cache" button on the top.

4. To verify if the installation was successfull, look for a new option in `System / Web Services` menu called `REST - Users`. If you can't see it, make sure your admin user has permissions.

Now you're ready to start using it!

## Usage

Please do read [the note below](#a-note-about-basic-authentication) first.

If the installation is done properly, you should see a new option in `System / Web Services` menu called `REST - Users`, that's where you'll be able to create and manage the users that will be able to connect to the REST Api through Basic authentication.

Creating a user is not enough though, you'll have to give it access to some resources. This can be done the same way as usual by creating a REST Admin Role (`System / Web Services / REST - Roles`), then assigning it the user you created.
Similarly, you'll have to also decide which resource attributes your REST users will have access to by going to `System / Web Services / REST - Attributes`, selecting `REST User` from the grid and selecting them from there.

Now you're ready to issue your first request! But first, you'll have to generate your authentication token, that is done by joining your username and password (Api key) with a colon (`:`) and encoding them in `base64` (replace `<username>` and `<password>` with your own):

```sh
$ php -r "echo base64('<username>:<password>') . PHP_EOL;"
```

You can now issue requests using your token (replace `<token>` with your own):

```sh
$ curl http://yourdomain.tld/api/rest/orders -H 'Accept: application/json' -H 'Authorization: Basic <token>'
```

If you get `Access denied` error, check that the role assigned to your user has access to the resource you're trying to access, and that your user is active. Additionally, you can check the logs.

*Note: you may have noticed that this extension adds some new files to `app/code/local`. Those files are required to be able to use Basic authentication with the built-in REST endpoints in Magento, and because of the way it works, you need to add them in the same namespace as the module concerned (i.e. adding them inside the extension won't work). You can choose to not add them if you don't care about that.*

## A note about Basic authentication

Basic authentication is generally discouraged nowadays because it involves transfering user credentials over the network in `base64` encoding, which can easily be decoded and viewed in plaintext. It is highly recommended that you use it **only** with an encrypted connection, and **never** issue requests from the client side as to not expose user credentials.

## Contributing

Please feel free to open an Issue if you find any bug, or have something to suggest. Translations to other languages are very welcome :).

## License

This project is licensed under the [MIT License](LICENSE).
