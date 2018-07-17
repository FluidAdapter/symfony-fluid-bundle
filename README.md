# FluidBundle

## Installation

1. install package

```
composer require fluid-adapter/symfony-fluid-bundle
```

2. activate bundle

Add ```FluidAdapter\SymfonyFluidBundle\FluidBundle::class => ['all' => true]``` to the Bundles-Array in the ```config\bundles.php```

3. add fluid template engine

Add ```fluid``` to the ```framework.templating.engines``` array in ```config/packages/framework.yaml```

## Rendering Fluid Templates

You can simply use the built-in render method in the controller to render a fluid template like this:

```
  return $this->render('Default/Index.html', [
    'foo' => 'bar'
  ]);
```

## Template Paths

Templates are loaded from ```src/Resources/views/Templates/```, ```src/Resources/views/Layouts/``` and ```src/Resources/views/Partials/```

| render argument      | template path                                       |
|----------------------|-----------------------------------------------------|
| AppBundle:Blog:Index | AppBundle/Resources/views/Templates/Blog/Index.html |
| Default/Index.html   | src/Resources/views/Templates/Default/Index.html    |
