<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Clients\Qss\Qss;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Transformers\Qss\AuthorTransformer as QssAuthorTransformer;

class CreateAuthorCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qss:create-author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an author using the QSS API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->getValueWithValidation('email', 'Enter email for login', 'required|email');
        $password = $this->getValueWithValidation('password', 'Enter password for login', 'required', true);

        $qss = new Qss();

        try {
            $response = $qss->token()->get($email, $password);
            $responseBody = json_decode($response->getBody(), true);
            $token = $responseBody['token_key'];
        } catch(HttpException $e) {
            if($e->getCode() === 403) {
                $this->error('User not found or inactive or password not valid.');
            } else {
                $this->error('Something went wrong! Please try again.');
            }

            return 1;
        }

        if(empty($token)) {
            $this->error('No token was returned.');
            return 1;
        }

        $client->setToken($token);

        $firstName = $this->getValueWithValidation('firstName', 'Enter the first name of the author', 'required|min:2|max:255');
        $lastName = $this->getValueWithValidation('lastName', 'Enter the last name of the author', 'required|min:2|max:255');
        $birthday = $this->getValueWithValidation('birthday', 'Enter the birthday of the author (e.g. 20-06-1991)', 'required|date|before:now');
        $biography = $this->getValueWithValidation('biography', 'Enter the biography of the author', 'required|min:2');
        $gender = $this->choice('Select the gender of the author', ['male', 'female']);
        $placeOfBirth = $this->getValueWithValidation('placeOfBirth', 'Enter the place of birth of the author', 'required|min:2');

        try {
            $response = $client->createAuthor([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'birthday' => $birthday,
                'biography' => $biography,
                'gender' => $gender,
                'place_of_birth' => $placeOfBirth
            ]);
            $item = json_decode($response->getBody(), true);
            $author = Author::createFromTransformer(new QssAuthorTransformer($item));

            $this->line('Author successfully created.');
            $this->table(
                ['ID', 'FirstName', 'LastName', 'Birthday', 'Biography', 'Gender', 'PlaceOfBirth'],
                [
                    [$author->id, $author->firstName, $author->lastName, $author->birthday?->format('d-m-Y'), $author->biography, $author->gender, $author->placeOfBirth]
                ]
            );
        } catch(HttpException) {
            $this->error('Something went wrong while trying to create a new author.');
        }

        return 1;
    }

    public function getValueWithValidation(string $key, string $question, string $rules, bool $secret = false): string
    {
        $value = null;

        while(empty($value)) {
            $input = $secret ? $this->secret($question) : $this->ask($question);
            $validator = Validator::make([$key => $input], [$key => $rules]);
            $errors = $validator->errors();

            if($errors->get($key)) {
                foreach ($errors->get($key) as $message) {
                    $this->error($message);
                }
            } else {
                $value = $input;
            }
        }

        return $value;
    }
}
