# Laravel Hackernews API

This project is a RESTful API built with Laravel that serves data from the popular news site Hackernews.

## Getting Started

To get started, you'll need to clone this repository and install the dependencies. Here are the steps:

1. Clone the repository:

    ```
    git clone https://github.com/idoko-emmanuel/Laravel-HackerNews-API.git
    ```

2. Navigate to the project directory:

    ```
    cd Laravel-HackerNews-API
    ```

3. Install the dependencies:

    ```
    composer install
    ```

4. Copy the .env.example file and rename it to .env:

    ```
    cp .env.example .env
    ```

5. Generate a new application key:

    ```
    php artisan key:generate
    ```

6. Set up the database by setting the necessary variables in the .env file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hackernews
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7. Run the database migrations:

    ```
    php artisan migrate
    ```

8. Start the server:

    ```
    php artisan serve
    ```


9. You're all set! You can now make requests to the API at http://127.0.0.1:8000/api/v1/.


## Config
You can configure the Laravel HackerNews API project by modifying the hackernews.php config file located in the config folder.

### Setting the Hacker News URL Endpoint
You can set the Hacker News URL endpoint from your .env file by using the HACKERNEWS_URL variable. If it's not set, the available default in the configuration file will be used.

### API Version
You can setup the version of your API endpoint in the hackernews.php config file. The default is set to "v1" which stands for version one. To set it up, update the value of the apiversion key to the desired version.

### Spool Type
For queued jobs, you can set the spool type as well from the hackernews.php config file in the config folder. You can set spool type by assigning any of these types: max, top, new, show, ask, job, best. The default is max.

### Email for Output on Dispatch Failure
During queued jobs, you may run into some errors when dispatching the jobs. To get proper error message, set the email for the messages to return to in the hackernews.php parameter. Update the email key to your desired value.

## Usage
To use the HackernewsData facade, you need to first import it at the top of your file using the following code:

    use App\Services\Facades\HackernewsData;

## Storing Data
You can then call any of the available methods to store data from the Hacker News API. For example, to store data from the maximum item:

    $response = HackernewsData::spoolFromMaxItem();

## Returning Response as JSON
The response from the HackernewsData facade can then be returned as a JSON response using Laravel's response() function:

    return response()->json([
        "message" => $response." from maximum item.",
    ], 200);

## Example
Here is an example of how to use the HackernewsData facade in a controller:

    namespace App\Http\Controllers;

    use App\Services\Facades\HackernewsData;

    class HackernewsController extends Controller
    {
        public function spoolmax()
        {
            $response = HackernewsData::spoolFromMaxItem();

            return response()->json([
                "message" => $response." from maximum item.",
            ], 200);
        }
    }

In the example above, the spoolmax() method stores data from the maximum item and returns the response as a JSON response. You can use this as a starting point for creating your own methods to store data from other endpoints in the Hacker News API.

## Jobs
To store data from the Hackernews API, you can use the FetchHackernewsData job. This job stores the data according to the spooltype specified in the configuration file.

You can run your queue worker with this command:

    php artisan queue:work

To setup your queue to use the database queue driver, kindly refer to the [documentation](https://laravel.com/docs/10.x/queues#driver-prerequisites)

## Configuration
To configure the spooltype for the Hackernews API, set the 'spooltype' value in your hackernews.php file. The options are:

- max: spool from maximum item.
- top: spool from top stories.
- new: spool from new stories.
- show: spool from show stories.
- ask: spool from ask stories.
- job: spool from jobs.
- best: spool from best stories.

## Execution
To execute the job, you can run the php artisan queue:work command. This will start the Laravel queue worker, which will process any pending jobs in the queue.

Once the queue worker is running, you can add jobs to the queue using the dispatch method.

## Command
The app:fetch-data command is used to fetch data from the Hacker News API. To use this command, navigate to your project's root directory and run the following command in your terminal:

    php artisan app:fetch-data

This will dispatch the FetchHackernewsData job which will fetch the data from the API and store it in your database. You can configure the type of data to fetch by updating the spooltype configuration option in your config/hackernews.php file.

After running the command, you will see a message indicating that the command was successful. The fetched data will be stored in your database and can be accessed via your application's models.

## Schedules
The Kernel.php file in the Console directory is used to define the schedule for the commands that need to be run periodically. In this application, we have defined a command that fetches data from the Hacker News API and it is scheduled to run twice daily at 1am and 1pm. If the command fails to execute, an email notification will be sent to the specified email address.

To run the task scheduler Locally use this command:

    php artisan schedule:work


## Endpoints
You can setup the version of your API endpoint in the hackernews config file. The default is set to "v1" which stands for version one.

Here are the available endpoints:

- `GET /api/v1/spool/max`: Gets the maximum item ID.
- `GET /api/v1/spool/top`: Gets the top stories.
- `GET /api/v1/spool/new`: Gets the newest stories.
- `GET /api/v1/spool/show`: Gets a specific story.
- `GET /api/v1/spool/ask`: Gets the latest Ask HN posts.
- `GET /api/v1/spool/job`: Gets the latest job posts.
- `GET /api/v1/spool/best`: Gets the best stories.

## Documentation

Please refer to the [published documentation](https://documenter.getpostman.com/view/25554207/2s93RWMq9s) for detailed information on each endpoint and how to use them.

## Testing

This application comes with both unit and feature tests.

To run the tests, navigate to the root directory of the project and run the following command:

    php artisan test

## Unit Testing
Unit tests have been provided for the following components:

- Author
- Comment
- Job
- Poll
- PollOption
- Story

## Feature Testing
Feature tests have been provided for the HackernewsController.

To speed up the testing process, it is recommended to decrease the amount of data that is fetched and stored by the HackernewsDataService.php file located in the Services directory.

## Stack Version
Laravel 10 and PHP 8

## Contributing

Contributions are welcome! If you have an idea for a new feature or would like to fix a bug, please create a new issue or submit a pull request.

## License

This project is open source and available under the [MIT License](https://opensource.org/licenses/MIT).
