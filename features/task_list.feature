Feature: Filter tasks

    Scenario: Consulta sin parámetros
        Given a fixtured database with group "test"
        When I send a GET request to "/api/tasks"
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON node "" should have 500 elements

    Scenario: Consulta con filtro title
        Given a fixtured database with group "test"
        When I send a GET request to "/api/tasks" with parameters:
        | key   | value |
        | title | odio |
        Then the response status code should be 200
        And the response should be in JSON
        And the JSON node "" should have 5 elements

