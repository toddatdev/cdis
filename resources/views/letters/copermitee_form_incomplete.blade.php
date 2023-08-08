<div class="copermitee_form_incomplete dependent-list-item ">
    <form action="">
        <div class="form-group col-md-12">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-12 mt-4">
            <div class="i-checks">
                <label for="check-all">
                    <input type="checkbox" class="check-all" id="check-all"> <i class="ml-1"></i>
                    <strong>Check All</strong>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_1">
                    <input type="checkbox" id="cb_1" name="deficiencies[]" class="cbi"
                           value="Provide the site address/location in section C of the co-permittee form.">
                    <i class="ml-1"></i> Provide the site
                    address/location in section C of the co-permittee form.
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_2">
                    <input type="checkbox" class="cbi" id="cb_2" name="deficiencies[]" value="Provide the necessary information for the co-permittee in Section D of the co-permittee form."> <i
                            class="ml-1"></i> Provide the necessary information for the co-permittee in Section D of the co-permittee form.
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_3">
                    <input type="checkbox" class="cbi" name="deficiencies[]" value="Provide the original form with the notary seal to the District, copies will not be accepted." id="cb_3"> <i
                            class="ml-1"></i> Provide the original form with the notary seal to the District, copies will not be accepted.
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_4">
                    <input type="checkbox" class="cbi" name="deficiencies[]" value="Provide the correct name on the co-permittee form as is provided on the NPDES Permit" id="cb_4"> <i class="ml-1"></i>
                    Provide the correct name on the co-permittee form as is provided on the NPDES Permit
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_5">
                    <input type="checkbox" class="cbi" name="deficiencies[]" value="The co-permittee agreement form was not signed by both parties" id="cb_5"> <i class="ml-1"></i> The co-permittee agreement form was not signed by both parties
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb_6">
                    <input type="checkbox" class="cbi" name="deficiencies[]" value="The compliance history section was not completed." id="cb_6"> <i class="ml-1"></i> The compliance history
                    section was not completed.
                </label>
            </div>
        </div>

    </form>
</div>
