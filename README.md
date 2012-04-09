EmkaFeatureToggleBundle
=======================

This bundle helps you easily configure your feature toggling in Symfony2
by adding some simple tags to php twig and extending it's configuration.

It's under developement, and it's not usable at this moment.

Configuring your features
-------------------------

You could add to your config.yml the following lines:

```
feature_toggle:
	features:
		my_feature:
			name: my_feature # the name you use in your template
			enabled: true    # false
```

Use feature toggling in you templates
-------------------------------------

Once you configured your features, you can surround it with the `feature`block in you Twig template.

```
{% feature 'my_feature' %}
  {% if true %}
    ... add you code
  {% endif %}
{% endfeature %}
```
