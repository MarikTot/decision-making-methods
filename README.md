### Как разворачивать проект
1. Устанавливаем докер
2. Переходим в папку с проектом
3. Выполняем команды:

```
    docker network create dmm-network
    docker-compose up -d
    docker-compose exec workspace composer install
    docker-compose exec workspace php bin/console d:d:c
    docker-compose exec workspace php bin/console d:m:m
    docker-compose exec workspace npm install
    docker-compose exec workspace npm run build
```
Если это дев среда, то вы можете загрузить фикстуры:
```
    docker-compose exec workspace php bin/console d:f:load
```
Если это прод, то выполнить надо выполнить команду, которая создаст администратора:
```
    docker-compose exec workspace php bin/console app:fill-data
```
4. Система должна быть доступна по адресу http://localhost:80

### Как добавить новый метод

1. Добавляем новый метод
```
    \App\Enum\DecisionMakingMethod
```
2. Создаем стратегию в папке
```
    src/Service/TaskSolver/Strategy/
```
3. Реализуем интерфейс

```
    \App\Service\TaskSolver\Strategy\SolverStrategyInterface
```

* метод `getName()` должен вернуть метод из `DecisionMakingMethod`
* метод `solve` должен вернуть решением этим методом в массиве любой структуры

4. Добавить в класс `SolverStrategyFactory` в метод `create` новый метод

5. В папку `assets/vue/components/methods` добавить компонент для отображения результата нового метода
6. В компонент `assets/vue/components/ResultItem.vue` в `div` на 29 строчке добавить новый компонент 
