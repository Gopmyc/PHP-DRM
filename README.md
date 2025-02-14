# PHP-DRM

## Description

PHP-DRM is a Digital Rights Management (DRM) system developed in PHP and Lua. It uses 256-bit RSA encryption to secure communications and authentication keys. The project includes functionality for key generation and validation, as well as base64 encoding/decoding using Lua.

The system stores authentication information in an SQLite database and uses JSON files to store public and private RSA keys.

## Project Structure

```
.
├── index.php            # Main entry point of the project
├── keyValidator.php     # Key authentication validation
├── setup.php            # Project installation and initialization
├── utils.php            # Utility functions
├── php.ini              # Utility php libraries
├── replit.nix           # Configuration for the Replit environment
└── lua/
    ├── rsa.lua          # Lua script for RSA encryption
    ├── keygen.lua       # RSA key generation script
    └── libraries/
        ├── base64.lua   # Lua library for base64 encoding/decoding
        └── json.lua     # Lua library for JSON parsing
```

## Dependencies

- **PHP** 8.2 (or higher) [php](https://www.php.net/releases/8.2/en.php)
- **Lua** 5.1 [lua](https://www.lua.org/source/5.1/)

## Installation

1. Clone the repository or download the files.
2. Install the required dependencies for PHP and Lua on your system.
3. Run the `setup.php` script to initialize the project. This will create the `data/` and `key/` directories, along with the necessary files (`client.db`, `private.json`, `public.json`).
4. You can delete the `data/` and `key/` folders to regenerate new ones if needed (they will be generated when the server is launched).
5. You can modify constant references in config.php to use environment tools, such as the `lua` entry point

## Usage

### Running the server

The `index.php` file is the main entry point. It retrieves the necessary information, parses arguments, and handles authentication requests.

### Authentication Requests

To validate a key, the `key` argument must be passed in the request. For example:

```bash
php index.php --key=<your_key>
```

### RSA Encryption and Base64 Encoding

Lua handles the following processes in the project:

- **RSA Encryption**: The `rsa.lua` script handles encrypting and decrypting data with the private and public keys.
- **Key Generation**: The `keygen.lua` script is responsible for generating new RSA key pairs.
- **Base64 Encoding/Decoding**: The `base64.lua` library provides functionality for encoding and decoding data in Base64.
- **JSON Parsing**: The `json.lua` library is used for parsing JSON data within the project.

### Deleting Data and Keys

If you wish to reset the project and generate new keys, you can delete the `data/` and `key/` directories. The project will automatically regenerate the necessary files the next time it is launched.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.