Feature: Edit task

    Scenario: Edit ok
        Given a fixtured database with group "test1"
        When I send a PUT request to "/api/tasks/task1" with body:
        """
{
  "title": "TITULO DE PRUEBA",
  "description": "DESCRIPTION",
  "type": "task",
  "epic": "epic3"
}
        """
        Then the response status code should be 200
        And the response should be in JSON
