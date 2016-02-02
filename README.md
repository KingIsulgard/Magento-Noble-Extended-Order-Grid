# Noble Extended Order Grid for Magento
This Magento extension gives the user the flexibility to customize the orders grid in the admin by removing existing columns or even adding custom columns to the grid.

## Overview
* [Features](#features)
* [Implementation](#implementation)
* [Configuration](#configuration)
* [Screen](#screens)
* [Donation](#donate)
* [Changelog](#changelog)
* [License](#license)
* [Warranty](#warranty)

## Features
- Turn off any of the default columns with a simple Yes/No
- Add new custom columns
- Available custom columns are: 
- Shipping method
- Payment method
- Shipping country
- Billing country
- Customer email
- Amount of items in the order
- Subtotal
- Customer Group

## Implementation
Simply upload the files in the app folder to the app folder of your Magento installation. It is recommended to test this on a test server first. The current module has been tested with Magento Community 1.7.X, 1.8.X and 1.9.X

Usually you will be required to log out and log back in in order for it to work.

## Configuration
Configuring the columns is very easy. Just login to your Magento Admin panel, go to Configuration. And on the left choose the "Extended Order Grid" link in the "Noble Extensions" section.

## Screens
Some screenshots of the module in action.
![Configuration](https://raw.githubusercontent.com/KingIsulgard/Magento-Noble-Extended-Order-Grid/master/configuration.png)
![Grid](https://raw.githubusercontent.com/KingIsulgard/Magento-Noble-Extended-Order-Grid/master/grid.png)

## Donate
You can support [contributors](https://github.com/KingIsulgard/Magento-Noble-Extended-Order-Grid/graphs/contributors) of this project individually. Every contributor is welcomed to add his/her line below with any content. Ordering shall be alphabetically by GitHub username.

Please consider a small donation if you use Magento-Noble-Extended-Order-Grid on your store. It would make me really happy.

* [@KingIsulgard](https://github.com/KingIsulgard): <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HQE64D8RQGPLC"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="[paypal]" /></a> !

## Changelog
### Version 1.0.1
Countries can now be displayed as either the full country name or the country code. Added extra custom columns Shipping Region, Billing Region, Shipping City, Billing City, Shipping Postcode, Billing Postcode

## License
The license for the code is included with the project; it's basically a BSD license with attribution.

You're welcome to use it in commercial, closed-source, open source, free or any other kind of software, as long as you credit me appropriately.

## Warranty
The code comes with no warranty of any kind. I hope it'll be useful to you (it certainly is to me), but I make no guarantees regarding its functionality or otherwise.
