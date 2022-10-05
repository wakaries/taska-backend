Feature: Post task

    Scenario: Post ok
        Given a fixtured database with group "test1"
        When I send a POST request to "/api/tasks" with body:
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
