<?php

namespace App\Core;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class Container
{
    public function make(string $class): object
    {
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
}
