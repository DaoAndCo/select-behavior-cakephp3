# select-behavior-cakephp3

Create a key-value list with an optionnal group key, compatible with the method find('list').

When you want to use 'list' results in javascript, it can be a little tricky because of the lack of fixed key.
So, this behavior helps you to get a JS-friendly format for your lists.

With normal find('list') you'll get your results as :
```
$list = [
  "31555" => "Toulouse",
  "31075" => "Bonrepos sur aussonnelle",
  ...
]
```
or, with a groupField key :
```
$list = [
  "Midi-Pyrénées" => [
    "31555" => "Toulouse",
    "31075" => "Bonrepos sur aussonnelle",
    ...
  ],
  ...
]
```

With the behavior 'select', with find('select') you'll get results as :
```
$list = [
  [
    "items" => [
      [
        "key"   => "31555",
        "value" => "Toulouse"
      ],
      [
        "key"   => "31075",
        "value" => "Bonrepos sur Aussonnelle"
      ],
      ...
    ]
  ]
]
```
and with a groupField key :
```
$list = [
  [
    "group" => "Midi-Pyrénées",
    "items" => [
      [
        "key"   => "31555",
        "value" => "Toulouse"
      ],
      [
        "key"   => "31075",
        "value" => "Bonrepos sur Aussonnelle"
      ],
      ...
    ]
  ],
  ...
]
```

##Installation

```
composer require orken/select-behavior-cakephp3
```
