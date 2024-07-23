<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $dataProviderX = json_decode(file_get_contents(storage_path('app/DataProviderX.json')), true);
        $dataProviderY = json_decode(file_get_contents(storage_path('app/DataProviderY.json')), true);

        // Marge Data
        $users = array_merge(
            array_map([$this, 'transformDataProviderX'], $dataProviderX),
            array_map([$this, 'transformDataProviderY'], $dataProviderY)
        );


        if ($request->has('provider')) {
            $users = array_filter($users, function($user) use ($request) {
                return $user['provider'] == $request->query('provider');
            });
        }

        if ($request->has('statusCode')) {

            $statusCodeMap = [
                'authorised' => [StatusCode::AUTHORISED_X, StatusCode::AUTHORISED_Y],
                'decline' => [StatusCode::DECLINE_X, StatusCode::DECLINE_Y],
                'refunded' => [StatusCode::REFUNDED_X, StatusCode::REFUNDED_Y]
            ];
            $statusCodes = $statusCodeMap[$request->query('statusCode')] ?? [];
            $users = array_filter($users, function($user) use ($statusCodes) {
                return in_array($user['statusCode'], $statusCodes);
            });
        }

        if ($request->has('balanceMin')) {
            $balanceMin = $request->query('balanceMin');
            $users = array_filter($users, function($user) use ($balanceMin) {
                return $user['balance'] >= $balanceMin;
            });
        }

        if ($request->has('balanceMax')) {
            $balanceMax = $request->query('balanceMax');
            $users = array_filter($users, function($user) use ($balanceMax) {
                return $user['balance'] <= $balanceMax;
            });
        }

        if ($request->has('currency')) {
            $currency = $request->query('currency');
            $users = array_filter($users, function($user) use ($currency) {
                return $user['currency'] == $currency;
            });
        }

        $paginate = $request->get('paginate',0);

        if($paginate == 1) {
            // Pagination
            $perPage = $request->query('perPage', 15);
            $page = $request->query('page', 1);
            $offset = ($page - 1) * $perPage;

            $usersCollection = new Collection($users);
            $paginatedUsers = new LengthAwarePaginator(
                $usersCollection->slice($offset, $perPage)->values(),
                $usersCollection->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return response()->json($paginatedUsers);
        }

        return response()->json($users);
    }

    private function transformDataProviderX($user)
    {
        return [
            'balance' => $user['parentAmount'],
            'currency' => $user['Currency'],
            'email' => $user['parentEmail'],
            'statusCode' => $user['statusCode'],
            'date' => $user['registerationDate'],
            'provider' => 'DataProviderX'
        ];
    }

    private function transformDataProviderY($user)
    {
        return [
            'balance' => $user['balance'],
            'currency' => $user['currency'],
            'email' => $user['email'],
            'statusCode' => $user['status'],
            'date' => $user['created_at'],
            'provider' => 'DataProviderY'
        ];
    }
}
