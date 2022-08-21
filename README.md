# Async-Laravel-Pipelines-Test
una specie di pipeline pattern per jobs concatenati

da mettere in bella, comunque l'idea sarebbe di portare le pipeline in 'sto contesto, in un modo del genere: 
```
        DispatchChainer::dispatch((object) $obj,            
        [
            FooJob::class,
            Foo2Job::class,
        ]);
```
