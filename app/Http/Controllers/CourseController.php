<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\Courses\CourseRequest;
use App\Http\Resources\Course\CourseResource;

class CourseController
{
    public function index()
    {
        return CourseResource::collection(Course::all());
    }

    public function show($uuid)
    {
        $course = Course::where("uuid", $uuid)->first();

        return new CourseResource($course);
    }

    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $course = new Course();
        $course->name = $request->name;
        $course->code = $request->code;
        $course->save();

        return response()->json([
            'data' => [
                'uuid' => $course->uuid,
            ]
        ], 201);
    }
}
