<?php

namespace App\Helpers\Training;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TrainingAPI
{
    /**
     * Fetch questionnaire by its id and language
     */
    public static function fetchQuestionnaires(int|array $questionnaireId, array $languages = [], bool $dataAsObject = false): array
    {
        $apiPayload = [];
        $apiPayload['role'] = 'GETQUESTIONNAIRELANGUAGE';
        $apiPayload[is_array($questionnaireId) ? 'questionnaire_ids' : 'questionnaire_id'] = $questionnaireId;
        if ($languages) {
            $apiPayload['languages'] = $languages;
        }

        $response = self::makeApiRequest('POST', self::apiUrl('questionnaire'), $apiPayload);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire data could not be found.',
            ];
        }

        /* In some part of code response treated as object, so using this parameter, it $dataAsObject=true than return
        response as object. */
        if ($dataAsObject) {
            $response = $response->object();

            return [
                'status' => true,
                'message' => 'Questionnaire found.',
                'data' => count($languages) === 1 ? $response->data[0] : $response->data,
            ];
        } else {
            return [
                'status' => true,
                'message' => 'Questionnaire found.',
                'data' => count($languages) === 1 ? $response->json('data')[0] : $response->collect('data'),
            ];
        }

    }

    /**
     * Fetch questionnaire languages by its id
     */
    public static function fetchQuestionnaireLanguages(array $questionnaireIds): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('questionnaire'), [
            'role' => 'GETLANGUAGEBYQUESTIONNAIREID',
            'questionnaire_ids' => $questionnaireIds,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire language data could not be found.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire language found.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Save questionnaire languages
     */
    public static function saveQuestionnaireLanguages(array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('questionnaire'), [
            'role' => 'SAVEQUESTIONNAIRELANGUAGE',
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire language could not be saved.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire language has been successfully saved.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Update questionnaire language
     */
    public static function updateQuestionnaireLanguage(int $questionnaireId, string $language, array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('questionnaire'), [
            'role' => 'UPDATEQUESTIONNAIRELANGUAGE',
            'questionnaire_id' => $questionnaireId,
            'language' => $language,
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire language data could not be updated.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire language has been successfully updated.',
        ];
    }

    /**
     * Delete questionnaire language
     */
    public static function deleteQuestionnaireLanguage(int $questionnaireId): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('questionnaire'), [
            'role' => 'DELETEQUESTIONNAIRELANGUAGE',
            'questionnaire_id' => $questionnaireId,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire language data could not be deleted.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire language has been successfully deleted.',
        ];
    }

    /**
     * Fetch questionnaire training by training id
     */
    public static function fetchQuestionnaireTraining(int $trainingId): array
    {
        $response = self::makeApiRequest('GET', self::apiUrl('training'), [
            'role' => 'GETQUESTIONNAIRETRAINING',
            'training_id' => $trainingId,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire training data could not be found.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire training found.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Fetch training language data by training id
     */
    public static function fetchTrainingLanguage(int $trainingId): array
    {
        $response = self::makeApiRequest('GET', self::apiUrl('training'), [
            'role' => 'GETTRAINING',
            'training_id' => $trainingId,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Training data could not be found.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Training found.',
            'data' => $response->collect('data'),
        ];
    }

    /**
     * Save training language data
     */
    public static function saveTraining(array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('training'), [
            'role' => 'SAVETRAINING',
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Training language data could not be saved.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Training language data has been successfully saved.',
        ];
    }

    /**
     * Update training language data
     */
    public static function updateTraining(array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('training'), [
            'role' => 'UPDATETRAINING',
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Training language data could not be updated.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Training language data has been successfully updated.',
        ];
    }

    /**
     * Delete Training
     */
    public static function deleteTraining(int $trainingId): array
    {
        $response = self::makeApiRequest('GET', self::apiUrl('training'), [
            'role' => 'DELETEQUESTIONNAIRETRAINING',
            'training_id' => $trainingId,
        ]);

        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Training could not be deleted.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Training has been successfully deleted.',
        ];
    }

    /**
     * Save questionnaire training
     */
    public static function saveQuestionnaireTraining(array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('training'), [
            'role' => 'SAVEQUESTIONNAIRETRAINING',
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire training data could not be saved.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire training data has been successfully saved.',
        ];
    }

    /**
     * Update questionnaire training
     */
    public static function updateQuestionnaireTraining(array $apiPayload): array
    {
        $response = self::makeApiRequest('POST', self::apiUrl('training'), [
            'role' => 'UPDATEQUESTIONNAIRETRAINING',
            'data' => $apiPayload,
        ]);
        if ($response->failed() || ! $response->json('status')) {
            return [
                'status' => false,
                'message' => 'Questionnaire training data could not be updated.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Questionnaire training has been successfully updated.',
        ];
    }

    /**
     * Generate training certificate
     *
     * @param array $apiPayload
     * @return array
     */
    public static function generateTrainingCertificate(array $apiPayload, string $certificateUrl): array
    {
        $apiPayload = [
            'certificateTxt' => [
                'details' => $apiPayload
            ],
            'imgl' => $certificateUrl,
            'base64' => true
        ];

        $response = self::makeApiRequest('POST', self::apiUrl('training_certificate'), $apiPayload);
        if ($response->failed() || $response->json('statusCode') != 200) {
            return [
                'status' => false,
                'message' => 'Training certificate could not be generated.',
            ];
        }

        return [
            'status' => true,
            'message' => 'Training certificate has been successfully generated.',
            'data' => $response->json('data'),
        ];
    }

    /**
     * @param string $type (Type : training or questionnaire)
     * @return string|null
     */
    private static function apiUrl(string $type): ?string
    {
        $urls = [];
        $urls['training']['development'] = 'https://7cfycksdfncsidr67jyfume2340hoips.lambda-url.ap-south-1.on.aws/';
        $urls['training']['production'] = 'https://wuiquqx7i5wfyr7b42l5ndtn6m0cqrdy.lambda-url.ap-south-1.on.aws/';
        $urls['questionnaire']['development'] = 'https://3oppr7rc376fdts5o3rh5jhl740mumbw.lambda-url.ap-south-1.on.aws/';
        $urls['questionnaire']['production'] = 'https://62lhfvjquhycio33s36fjqs4bq0xpguj.lambda-url.ap-south-1.on.aws/';
        $urls['training_certificate']['development'] = 'http://k8s-certific-testcert-1ea8efb041-880593152.ap-south-1.elb.amazonaws.com/api/Certificates';
        // Please change the production endpoint, while moving it to production.
        $urls['training_certificate']['production'] = 'http://k8s-certific-testcert-1ea8efb041-880593152.ap-south-1.elb.amazonaws.com/api/Certificates';

        return $urls[$type][config('app.env')] ?? '';
    }

    private static function makeApiRequest(string $method, string $url, array $apiPayload): mixed
    {
        $response = Http::acceptJson()
            ->asJson()
            ->timeout(200)
            ->retry(5, 1000)
            ->withBody(json_encode($apiPayload), 'application/json');

        /* While using retry in HTTP client, an exception will be thrown if the 5 attempts fail, or a timeout occurs.
        But I just want the response object returned. With the rescue() wrapper around the HTTP request,
        It's always receive a response object and can safely go ahead to verify its status. */

        $response = rescue(function () use ($response, $method, $url) {

            if ($method == 'GET') {
                $response = $response->get($url);
            } else {
                $response = $response->post($url);
            }

            return $response;
        }, function ($e) {
            Log::error('HTTP API request failed', ['error' => $e->getMessage()]);

            return new Response(new \GuzzleHttp\Psr7\Response(500, [], 'API Request failed'));
        });

        $response->throwIf($response->status() >= 500);

        return $response;
    }
}
