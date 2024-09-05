<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Lab;
use App\Models\Attendance;
use App\Mail\Mailgenerator;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'interesting' => 'required|string|max:1000',
             'engaging'  => 'required|string|max:1000',
             
        ]);
        $labnumber = auth()->user()->lab;
        $feedback = new Feedback();
        $feedback->lab = $labnumber;
        $feedback->f_understanding = $request->input('understanding');
        $feedback->f_confusing = $request->input('confusing');
        $feedback->f_interesting =$validatedData['interesting'];
        $feedback->f_engaging = $validatedData['engaging'];
        $feedback->f_important = $request->input('important');
        $feedback->f_overall = $request->input('overall');
        $feedback->f_difficulty = $request->input('difficulty');
        $feedback->save();
        return back()->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
        $labnumber = auth()->user()->lab;
        $afeed = Feedback::where('lab', $labnumber)->pluck('f_understanding');
        $frequencyofnum = $afeed->countBy();
            $totalsum = 0;
            $totalcount = 0;
         
        foreach ($frequencyofnum as $value => $frequency) {
            $totalsum += $value * $frequency;
            $totalcount += $frequency;
        }
        if ($totalcount > 0) {
            $avg = $totalsum / $totalcount;
            $average = ($avg * 100) / 5;
        } else {
            $avg = 0;
            $average = 0;  
        }   
            $afeedoverall = Feedback::where('lab', $labnumber)->pluck('f_overall');
            $frequencyoverall = $afeedoverall->countBy();
                $totalsumoverall = 0;
                $totalcountoverall = 0;
             
            foreach ($frequencyoverall as $valueoverall => $frequencyofoverall) {
                $totalsumoverall += $valueoverall * $frequencyofoverall;
                $totalcountoverall += $frequencyofoverall;
            }
            if ($totalcountoverall > 0) {
                $avgoverall = $totalsumoverall / $totalcountoverall;
                $averageoverall = (($avgoverall*100)/5);
            } else {
                $avgoverall = 0;
                $averageoverall = 0;  
            }    
                $afeeddifficulty = Feedback::where('lab', $labnumber)->pluck('f_difficulty');
                $frequencydifficulty = $afeeddifficulty->countBy();
                    $totalsumdifficulty = 0;
                    $totalcountdifficulty = 0;
                 
                foreach ($frequencydifficulty as $valuedifficulty => $frequencyofdifficulty) {
                    $totalsumdifficulty += $valuedifficulty * $frequencyofdifficulty;
                    $totalcountdifficulty += $frequencyofdifficulty;
                }
                
                if ($totalcountdifficulty > 0) {
                    $avgdifficulty = $totalsumdifficulty / $totalcountdifficulty;
                    $averagedifficulty = (($avgdifficulty*100)/5);
                } else {
                    $avgdifficulty = 0;
                    $averagedifficulty = 0;  
                }
                $positivewordfile = public_path('Feedback/positive_words.txt');
                $negativewordfile = public_path('Feedback/negative_words.txt');
                $poswords = file($positivewordfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $negwords = file($negativewordfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                
                // Analyze Sentiment for Feedback
                $feedbacks = Feedback::where('lab', $labnumber)->pluck('f_confusing');
                $positivecount = 0;
                $negativecount = 0;
                
                foreach ($feedbacks as $feedback) {
                    // Convert feedback to lowercase for case-insensitive matching
                    $feedback = strtolower($feedback);
                
                    // Check for positive words
                    foreach ($poswords as $posword) {
                        if (stripos($feedback, $posword) !== false) {
                            $positivecount++;
                        }
                    }
                
                    // Check for negative words
                    foreach ($negwords as $negword) {
                        if (stripos($feedback, $negword) !== false) {
                            $negativecount++;
                        }
                    }
                }
                
                $feedbackinteresting = Feedback::where('lab', $labnumber)->pluck('f_interesting');
                $feedbackengaging = Feedback::where('lab', $labnumber)->pluck('f_engaging');
                $feedbackimportant = Feedback::where('lab', $labnumber)->pluck('f_important');
                $feedbackconfusing = Feedback::where('lab', $labnumber)->pluck('f_confusing');
                
                $stopwords = [
                    'the', 'is', 'in', 'at', 'which', 'on', 'for', 'and', 'a', 'an', 'of', 'to', 'it', 'this', 'that', 'with',
                    'as', 'by', 'was', 'were', 'from', 'be', 'or', 'are', 'but', 'about', 'what', 'when', 'where', 'who', 'why',
                    'how', 'if', 'all', 'any', 'not', 'can', 'so', 'just', 'out', 'up', 'down', 'left', 'right', 'over', 'under',
                    'then', 'than', 'there', 'their', 'some', 'many', 'more', 'most', 'no', 'nor', 'only', 'own', 'same', 'such',
                    'too', 'very', 's', 't', 'will', 'now', 'd', 'll', 'm', 'o', 're', 've', 'y', 'ain', 'aren', 'couldn', 'didn',
                    'doesn', 'hadn', 'hasn', 'haven', 'isn', 'ma', 'mightn', 'mustn', 'needn', 'shan', 'shouldn', 'wasn', 'weren',
                    'won', 'wouldn'
                ];
                
                function getWordFrequencies($feedback, $stopwords) {
                    $feedbacktext = strtolower(implode(' ', $feedback->toArray()));
                    $words = str_word_count(preg_replace('/[^\w\s]/', '', $feedbacktext), 1);
                    $filteredWords = array_filter($words, function ($word) use ($stopwords) {
                        return !in_array($word, $stopwords);
                    });
                    $wordfrequencies = array_count_values($filteredWords);
                    arsort($wordfrequencies);
                    return $wordfrequencies;
                }                
                    $interesting = getWordFrequencies($feedbackinteresting, $stopwords);
                    $engaging = getWordFrequencies($feedbackengaging, $stopwords);
                    $important = getWordFrequencies($feedbackimportant, $stopwords);
                    $confusing = getWordFrequencies($feedbackconfusing, $stopwords);

                    $detailfeedback = Feedback::where('lab', $labnumber)->get();
                    $teachrole = auth()->user()->role;
                    $layout = $teachrole === 'ADMIN' ? 'layouts.admin' : 'layouts.ta';
                    return view('adminfeedback', compact('average', 'totalcount', 'averageoverall', 'averagedifficulty', 'positivecount', 'negativecount','interesting','engaging','important','confusing','detailfeedback','layout'));

    }
    private function analyzeSentiment($sentence,$poswords , $negwords)
    {
        $sentenceWords = explode(' ', strtolower($sentence));

        $positivecount = 0;
        $negativecount = 0;

        foreach ($sentenceWords as $word) {
            if (in_array($word, $poswords)) {
                $positivecount++;
            }
            if (in_array($word, $negwords)) {
                $negativecount++;
            }
        }

        if ($positivecount > $negativecount) {
            return 'Positive';
        } elseif ($negativecount > $positivecount) {
            return 'Negative';
        } else {
            return 'Neutral';
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function emaildata()
{
    $user = auth()->user();
    if ($user && $user->role == 'ADMIN') 
    {
        $labnumber = $user->lab;
        $adminname = $user->name;
        $afeed = Feedback::where('lab', $labnumber)->pluck('f_understanding');
        $frequencyofnum = $afeed->countBy();
        $totalsum = 0;
        $totalcount = 0;
     
        foreach ($frequencyofnum as $value => $frequency) {
            $totalsum += $value * $frequency;
            $totalcount += $frequency;
        }
        if ($totalcount > 0) {
            $avg = $totalsum / $totalcount;
            $average = ($avg * 100) / 5;
        } else {
            $avg = 0;
            $average = 0;  
        }   
        
        $afeedoverall = Feedback::where('lab', $labnumber)->pluck('f_overall');
        $frequencyoverall = $afeedoverall->countBy();
        $totalsumoverall = 0;
        $totalcountoverall = 0;
         
        foreach ($frequencyoverall as $valueoverall => $frequencyofoverall) {
            $totalsumoverall += $valueoverall * $frequencyofoverall;
            $totalcountoverall += $frequencyofoverall;
        }
        if ($totalcountoverall > 0) {
            $avgoverall = $totalsumoverall / $totalcountoverall;
            $averageoverall = (($avgoverall*100)/5);
        } else {
            $avgoverall = 0;
            $averageoverall = 0;  
        }    
        
        $afeeddifficulty = Feedback::where('lab', $labnumber)->pluck('f_difficulty');
        $frequencydifficulty = $afeeddifficulty->countBy();
        $totalsumdifficulty = 0;
        $totalcountdifficulty = 0;
         
        foreach ($frequencydifficulty as $valuedifficulty => $frequencyofdifficulty) {
            $totalsumdifficulty += $valuedifficulty * $frequencyofdifficulty;
            $totalcountdifficulty += $frequencyofdifficulty;
        }
        
        if ($totalcountdifficulty > 0) {
            $avgdifficulty = $totalsumdifficulty / $totalcountdifficulty;
            $averagedifficulty = (($avgdifficulty*100)/5);
        } else {
            $avgdifficulty = 0;
            $averagedifficulty = 0;  
        }

        $positivewordfile = public_path('Feedback/positive_words.txt');
        $negativewordfile = public_path('Feedback/negative_words.txt');
        $poswords = file($positivewordfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $negwords = file($negativewordfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $feedbacks = Feedback::where('lab', $labnumber)->pluck('f_confusing');
        $positivecount = 0;
        $negativecount = 0;
        
        foreach ($feedbacks as $feedback) {
            $feedback = strtolower($feedback);
        
            foreach ($poswords as $posword) {
                if (stripos($feedback, $posword) !== false) {
                    $positivecount++;
                }
            }
        
            foreach ($negwords as $negword) {
                if (stripos($feedback, $negword) !== false) {
                    $negativecount++;
                }
            }
        }

        $detailfeedback = Feedback::where('lab', $labnumber)->get();

        $atten = Attendance::where('lab', $labnumber)->get();
        $totalstud = Lab::where('t_lab', $labnumber)->value('t_no_stds');
        $present = Attendance::where('lab', $labnumber)->where('atten', 'Present')->count();
        $partialPresent= Attendance::where('lab', $labnumber)->where('atten', 'Partial_Present')->count();
        $absent = Attendance::where('lab', $labnumber)->where('atten', 'Absent')->count();
        $abs = $totalstud - ($present + $partialPresent + $absent);
        $totalabsent = $absent + $abs;
        
        $data = compact('average', 'totalcount', 'averageoverall', 'averagedifficulty', 'positivecount', 'negativecount', 'detailfeedback', 'labnumber', 'adminname','present','partialPresent','totalabsent');

        // Prepare email data
        $emailAddress = $user->name . '@swansea.com'; 
        Mail::to($emailAddress)->send(new Mailgenerator($data));

        return back()->with('success', 'Email sent!');
    } else {
        return back()->with('message', 'No admin found!')->with('status', 404);
    }
}
}
