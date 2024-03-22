<?php

namespace App\Core\Providers;

use App\Core\Providers\Interfaces\ServiceProviderInterface;
use Domain\User\Providers\UserServiceProviders;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class Container
{
    private static $bindings = [];

    public static function bind(string $interface, string $implementation)
    {
        self::$bindings[$interface] = $implementation;
    }

    public function make(string $class): object
    {
        if (interface_exists($class)) {
            if (isset(self::$bindings[$class])) {
                // Se for uma interface, eu recupero a implementação para ela.
                $class = self::$bindings[$class];
            }
        }

        try {
            $reflection = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            throw new Exception("Erro ao refletir sobre a classe {$class}: " . $e->getMessage());
        }

        if (!$reflection->isInstantiable()) {
            throw new Exception("A classe {$class} não pode ser instanciada.");
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency === null || $parameter->isOptional()) {
                throw new Exception("Não foi possível resolver a dependência para o parâmetro {$parameter->getName()} do construtor de {$class}");
            }

            // Verifica se o tipo de parâmetro é um tipo de classe definido pelo usuário
            if ($dependency instanceof ReflectionNamedType && !$dependency->isBuiltin()) {
                // Se for uma classe definida pelo usuário, faz a injeção da dependência recursivamente
                $dependencies[] = $this->make($dependency->getName());
            } else {
                // Se for um tipo de dado embutido do PHP, adiciona nulo
                $dependencies[] = null;
            }
        }

        // Instancia a classe com as dependências resolvidas e retorna
        return $reflection->newInstanceArgs($dependencies);
    }

    public static function registerServiceProviders(array $providers)
    {
        foreach ($providers as $provider) {
            $providerInstance = new $provider();
            if ($providerInstance instanceof ServiceProviderInterface) {
                $providerInstance->register();
            }
        }
    }
}
