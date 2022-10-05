Feature: Delete task

    Scenario: Delete ok
        Given a fixtured database with group "test1"
        When I send a DELETE request to "/api/tasks/task1"
        Then the response status code should be 200
        And the response should be in JSON
