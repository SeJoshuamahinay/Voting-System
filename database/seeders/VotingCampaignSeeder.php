<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VotingCampaign;
use App\Models\Candidate;
use Carbon\Carbon;

class VotingCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // School Campaign - Active
        $schoolCampaign = VotingCampaign::create([
            'title' => 'test test',
            'description' => 'Vote for your student council representatives. Your voice matters in shaping our school community!',
            'category' => 'school',
            'status' => 'active',
            'start_date' => Carbon::now()->subDays(2),
            'end_date' => Carbon::now()->addDays(5),
            'allow_multiple_votes' => false,
        ]);

        // Add candidates for school campaign
        Candidate::create([
            'voting_campaign_id' => $schoolCampaign->id,
            'name' => 'Maria Santos',
            'position' => 'President',
            'party_list' => 'Progressive Students Alliance',
            'description' => 'Committed to improving student welfare and campus facilities.',
            'vote_count' => 0,
        ]);

        Candidate::create([
            'voting_campaign_id' => $schoolCampaign->id,
            'name' => 'Juan Dela Cruz',
            'position' => 'President',
            'party_list' => 'Student Unity Party',
            'description' => 'Advocating for transparent governance and student empowerment.',
            'vote_count' => 0,
        ]);

        Candidate::create([
            'voting_campaign_id' => $schoolCampaign->id,
            'name' => 'Sofia Rodriguez',
            'position' => 'President',
            'party_list' => 'Independent',
            'description' => 'Fresh perspectives for a better student experience.',
            'vote_count' => 0,
        ]);

        // Community Campaign - Active
        $communityCampaign = VotingCampaign::create([
            'title' => 'Barangay Captain Election',
            'description' => 'Choose the leader who will serve our barangay for the next 3 years. Vote wisely!',
            'category' => 'community',
            'status' => 'active',
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDays(3),
            'allow_multiple_votes' => false,
        ]);

        // Add candidates for community campaign
        Candidate::create([
            'voting_campaign_id' => $communityCampaign->id,
            'name' => 'Roberto Garcia',
            'position' => 'Barangay Captain',
            'party_list' => 'Community First',
            'description' => 'Experienced leader with 10 years of public service.',
            'vote_count' => 0,
        ]);

        Candidate::create([
            'voting_campaign_id' => $communityCampaign->id,
            'name' => 'Elena Mercado',
            'position' => 'Barangay Captain',
            'party_list' => 'People\'s Choice',
            'description' => 'Young, dynamic, and ready to bring positive change.',
            'vote_count' => 0,
        ]);

        // Draft Campaign
        $draftCampaign = VotingCampaign::create([
            'title' => 'Class Representative Election',
            'description' => 'Vote for your class representative. Coming soon!',
            'category' => 'school',
            'status' => 'draft',
            'start_date' => Carbon::now()->addDays(7),
            'end_date' => Carbon::now()->addDays(14),
            'allow_multiple_votes' => false,
        ]);

        // Expired Campaign
        $expiredCampaign = VotingCampaign::create([
            'title' => 'Sports Club President',
            'description' => 'This election has concluded. Thank you to all who participated!',
            'category' => 'school',
            'status' => 'completed',
            'start_date' => Carbon::now()->subDays(10),
            'end_date' => Carbon::now()->subDays(3),
            'allow_multiple_votes' => false,
        ]);

        Candidate::create([
            'voting_campaign_id' => $expiredCampaign->id,
            'name' => 'Carlos Reyes',
            'position' => 'Sports Club President',
            'party_list' => null,
            'description' => 'Passionate about sports and student activities.',
            'vote_count' => 45,
        ]);

        Candidate::create([
            'voting_campaign_id' => $expiredCampaign->id,
            'name' => 'Ana Torres',
            'position' => 'Sports Club President',
            'party_list' => null,
            'description' => 'Dedicated athlete and team player.',
            'vote_count' => 38,
        ]);
    }
}
