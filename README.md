# FluidBundle

## Installation

1. install package

```
composer require fluid-adapter/symfony-fluid-bundle
```

2. activate bundle

Add ```new FluidAdapter\SymfonyFluidBundle\FluidBundle()``` to the Bundles in the ```app\AppKernel.php```

3. add fluid template engine

Add ```fluid``` to the ```framework.templating.engines``` array in ```app/config/config.yml```

## Rendering Fluid Templates

You can simply use the built-in render method in the controller to render a fluid template like this:

```
  return $this->render('Default/Index.html', [
    'foo' => 'bar'
  ]);
```

## Template Paths

Templates are loaded from ```app/Resources/views/Templates/```, ```app/Resources/views/Layouts/``` and ```app/Resources/views/Partials/```

| render argument      | template path                                       |
|----------------------|-----------------------------------------------------|
| AppBundle:Blog:Index | AppBundle/Resources/views/Templates/Blog/Index.html |
| Default/Index.html   | app/Resources/views/Templates/Default/Index.html    |