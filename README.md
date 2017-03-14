# Magento WP Rest Module #

Magento and WordPress were always the mighty combination as Magento is lacking quality CMS control. Over the years, there were many extensions developed to run Magento inside WordPress and vice versa. However, they were all lacking ability to naturally or easily connect Magento and WordPress and mostly — they were not SEO friendly.

Thanks to the [WP Rest API](https://developer.wordpress.org/rest-api/), clean WP-Magento integration if finally possible.

Magento WP Rest module solves problems caused by Magento's feature lacking CMS by integrating WordPress blog through WP Rest Api. With almost no configuration, your blog can now become natural part of your store. This will allow user to write content using WordPress and it's rich options, while posts, pages and categories will be showing in Magento.

Here is the overview of features provided by WP Rest module:
* To access single post, you can just use it's URL identifier: http://example.com/post-slug
* Same goes for page - http://example.com/page-url-slug
* To access list of posts from any category - http://example.com/category-slug
* SEO and user friendly urls
* Easy setup, with almost no configuration
* Cross domain support (WordPress does not have to run on the same server as Magento)

Requirements:
* WordPress: [WP-API](https://github.com/WP-API/WP-API) (v2.0-beta15)
* Magento: [Magento WP Rest Module](https://github.com/stuntcoders/stunt_mage_wprest) (this module)

## Configuration ##

Configuration for Magento WP Rest module can be found in *Magento Admin Panel -> System -> Configuration -> WordPress REST API*:

* **Base Uri** - Defines the url where WordPress API is located. Url must be absolute and can eaither on same or different domain than Magento store is. Example: http://example.com/wp-json/

Copyright StuntCoders — [Start Your Online Store Now](http://stuntcoders.com/)
