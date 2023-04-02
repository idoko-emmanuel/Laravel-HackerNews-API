<?php

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

    public function spooltop()
    {
        $response = HackernewsData::spoolFromTopStories();

        return response()->json([
            "message" => $response." from top stories.",
        ], 200);
    }

    public function spoolnew()
    {
        $response = HackernewsData::spoolFromNewStories();

        return response()->json([
            "message" => $response." from new stories.",
        ], 200);
    }

    public function spoolshow()
    {
        $response = HackernewsData::spoolFromShowStories();

        return response()->json([
            "message" => $response." from show stories.",
        ], 200);
    }

    public function spoolask()
    {
        $response = HackernewsData::spoolFromAskStories();

        return response()->json([
            "message" => $response." from ask stories.",
        ], 200);
    }

    public function spooljob()
    {
        $response = HackernewsData::spoolFromJobs();

        return response()->json([
            "message" => $response." from jobs.",
        ], 200);
    }

    public function spoolbest()
    {
        $response = HackernewsData::spoolFromBestStories();

        return response()->json([
            "message" => $response." from best stories.",
        ], 200);
    }
}
