Feature: Post task

    Scenario: Post ok
        Given a fixtured database with group "test"
        When I send a POST request to "/api/tasks" with body:
        """
{
  "title": "TITULO DE PRUEBA",
  "description": "DESCRIPTION",
  "type": "task",
  "epic": "defc0f2b-4339-358e-88c6-267e2e7e0438"
}
        """
        Then the response status code should be 200
        And the response should be in JSON
