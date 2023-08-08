<label for="lead-reviewer">Lead Reviewer</label>
<select name="reviewer" id="lead-reviewer" class="form-control">
    <option value="">Select Reviewer</option>
    @if(isset($reviewers))
        @foreach($reviewers as $reviewer)
            @if(($project->projectDetails->reviewer_id ?? '') === $reviewer->id)

                <option value="{{$reviewer->id}}"
                        selected>{{$reviewer->name}}</option>
            @else
                <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
            @endif
        @endforeach
    @endif
</select>
