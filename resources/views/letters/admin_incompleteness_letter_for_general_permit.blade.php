<div class="general_permit_incompleteness dependent-list-item ">
    <div class="row px-3">
        <div class="form-group col-md-4">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="pag01">
                    <input type="checkbox" name="pag0"
                           value="PAG-01 NPDES General Permit Coverage" id="pag01"/>
                    <i class="ml-1"></i>
                    <p class="d-inline">PAG-01 NPDES General Permit Coverage</p>
                </label>
            </div>
            <div class="i-checks">
                <label for="pag02">
                    <input type="checkbox" name="pag1"
                           value="PAG-02 NPDES General Permit Coverage" id="pag02"/>
                    <i class="ml-1"></i>
                    <p class="d-inline">PAG-02 NPDES General Permit Coverage</p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label>
                    <input type="checkbox" name="dep_has_developed"
                           value="DEP has developed a standardized review process and processing times for all permits or other authorizations that it issues or grants.  Pursuant to its Permit Review Process and Permit Decision Guarantee Policy (Document # 021-2100-001), DEP guarantees to provide permit decisions within the published time frames, provided applicants submit complete, technically adequate applications/registrations that address all applicable regulatory and statutory requirements, in the first submission.  Since you did not submit a complete and/or technically adequate application, DEP’s Permit Decision Guarantee is no longer applicable to your application.">
                    <i class="ml-1"></i>
                    <p class="d-inline">
                        <span class="font-weight-bold">(OPTIONAL - Use this paragraph only for Individual Permits And ESCGP NOIs)</span><br/>
                        DEP has developed a standardized review process and processing times for all permits or other authorizations that it issues or grants.  Pursuant to its Permit Review Process and Permit Decision Guarantee Policy (Document # 021-2100-001), DEP guarantees to provide permit decisions within the published time frames, provided applicants submit complete, technically adequate applications/registrations that address all applicable regulatory and statutory requirements, in the first submission.  Since you did not submit a complete and/or technically adequate application, DEP’s Permit Decision Guarantee is no longer applicable to your application.
                    </p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="admin">
                    <input type="checkbox" name="please_note"
                           value="Please note, the permit number for this project has been updated to conform to U.S. Environmental Protection Agency (EPA) requirements. All future correspondence will reference this new permit number.">
                    <i class="ml-1"></i>
                    <p class="d-inline">
                        <span class="font-weight-bold">(OPTIONAL - Use this paragraph only for permit renewals and major amendments after August 17, 2016 for non-PAD-numbered permits)</span><br/>
                        Please note, the permit number for this project has been
                        updated to conform to U.S. Environmental Protection Agency (EPA) requirements. All future
                        correspondence will reference this new permit number.
                    </p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="check-all"></label>
            <div class="i-checks">
                <label for="admin">
                    <input type="checkbox" class="check-all" value="1"> <i class="ml-1"></i>
                    <strong>Check All</strong>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="i-checks">
                <label for="cb-1">
                    <input type="checkbox" class="cbi"
                           value="1. 102.6(a)(1) – One original and one copy of the complete NOI form (3800-PM-BCW0405b)\r\n     were submitted and were completed as instructed in the PAG-02 NOI Instructions.\r"
                           id="cb-1" name="options[]"> <i class="ml-1"></i>1. 102.6(a)(1) – One original and one copy of the complete NOI form (3800-PM-BCW0405b) were submitted and were completed as instructed in the PAG-02 NOI Instructions.
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-1-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. All eligibility requirements of PAG-02 as specified in Section III.B of the General Permit\r\n        appear to be met."
                                   id="cb-1-a" name="options[][]" data-parent-id="cb-1"> <i class="ml-1"></i>a. All eligibility requirements of PAG-02 as specified in Section III.B of the General Permit appear to be met.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-1-b cb-1-all">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. The applicant is not proposing to use floodplain restoration or gravity injection wells as\r\n        PCSM BMPs.\r\n\r"
                                   id="cb-1-b" name="options[][]" data-parent-id="cb-1"> <i class="ml-1"></i>b. The applicant is not proposing to use floodplain restoration or gravity injection wells as PCSM BMPs.
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb-2">
                    <input type="checkbox" class="cbi"
                           value="2. 102.6(a)(1) – Two copies of County and Municipal Notification Forms (3800-FM-\r\n     BCW0271band 3800-FM-BCW0271c, respectively) with county and municipal\r\n     signatures or proof that the county and municipality received the forms\r\n     were submitted.\r\n\r"
                           id="cb-2" name="options[]"> <i class="ml-1"></i>2. 102.6(a)(1) – Two copies of County and Municipal Notification Forms (3800-FM-BCW0271band 3800-FM-BCW0271c, respectively) with county and municipal signatures or proof that the county and municipality received the forms were submitted.
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb-3">
                    <input type="checkbox" class="cbi"
                           value="3. 102.6(a)(2) – Two copies of the PNDI receipt (draft receipts not acceptable), which will\r\n     not expire prior to anticipated authorization of permit coverage, were submitted.\r\n\r"
                           id="cb-3" name="options[]"> <i class="ml-1"></i>3. 102.6(a)(2) – Two copies of the PNDI receipt (draft receipts not acceptable), which will not expire prior to anticipated authorization of permit coverage, were submitted.
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-4">
                    <input type="checkbox" class="cbi"
                           value="4. 102.6(a)(1) – One original and one copy of the complete E&S Module 1 (3800-PM-\r\n     BCW0406a) were submitted and were completed as instructed in the\r\n     PAG-02 NOI Instructions.\r"
                           id="cb-4" name="options[]"> <i class="ml-1"></i>4. 102.6(a)(1) – One original and one copy of the complete E&S Module 1 (3800-PM-BCW0406a) were submitted and were completed as instructed in the PAG-02 NOIInstructions.
                </label>
            </div>

            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. 102.4(b)(5)(ix) – Details were provided for all E&S BMPs (Question 5 of E&S\r\n        PlanInformation) (can be provided on E&S Plan Drawings)."
                                   id="cb-4-a" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>a. 102.4(b)(5)(ix) – Details were provided for all E&S BMPs (Question 5 of E&S PlanInformation) (can be provided on E&S Plan Drawings).
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. 102.4(b)(5)(viii) – Standard E&S Worksheets from the E&S Manual (or their equivalent)\r\n        were attached."
                                   id="cb-4-b" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>b. 102.4(b)(5)(viii) – Standard E&S Worksheets from the E&S Manual (or their equivalent) were attached.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. 102.4(b)(5)(viii) – Supporting E&S calculations were provided (for any calculation not\r\n        handled by a Standard E&S Worksheet or an equivalent)."
                                   id="cb-4-c" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>c. 102.4(b)(5)(viii) – Supporting E&S calculations were provided (for any calculation not handled by a Standard E&S Worksheet or an equivalent).
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. 102.4(c) – An Off-site Discharge Analysis was provided, if applicable."
                                   id="cb-4-d" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>d. 102.4(c) – An Off-site Discharge Analysis was provided, if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. 102.4(b)(5)(v) – If hydric soils are present, a wetland determination was submitted."
                                   id="cb-4-e" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>e.
                            102.4(b)(5)(v) – If hydric soils are present, a wetland determination was submitted.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-4-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. 102.4(b)(5)(xii) – If contaminated soils are present, documentation was provided that\r\n        pollutant levels do not exceed residential or non-residential MSCs for soil in Chapter 250\r\n        (Appendix A, Tables 3 and 4) for residential and non-residential sites, respectively,\r\n        unless a site-specific standard has been met under a state or federal cleanup program or\r\n        the applicant provides documentation of naturally occurring contamination.\r\n\r"
                                   id="cb-4-f" name="options[][]" data-parent-id="cb-4"> <i class="ml-1"></i>f. 102.4(b)(5)(xii) – If contaminated soils are present, documentation was provided that pollutant levels do not exceed residential or non-residential MSCs for soil in Chapter 250 (Appendix A, Tables 3 and 4) for residential and non-residential sites, respectively, unless a site-specific standard has been met under a state or federal cleanup program or the applicant provides documentation of naturally occurring contamination.
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-5">
                    <input type="checkbox" class="cbi"
                           value="5. 102.4(b)(5)(ix) – Two sets or copies of E&S Plan Drawing(s) were submitted.\r"
                           id="cb-5" name="options[]"> <i class="ml-1"></i>5. 102.4(b)(5)(ix) – Two sets or copies of E&S Plan Drawing(s) were submitted.
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. 102.4(b)(5)(i) – The Drawing(s) include existing and proposed topography (including any\r\n        temporary contours) with appropriate contour labels."
                                   id="cb-5-a" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>a.
                            102.4(b)(5)(i) – The Drawing(s) include existing and proposed topography (including any
                            temporary contours) with appropriate contour labels.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. 102.4(b)(5)(iii) – The Drawing(s) include the project site boundary."
                                   id="cb-5-b" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>b. 102.4(b)(5)(iii) – The Drawing(s) include the project site boundary.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. 102.4(b)(5)(iii) – The Drawing(s) include the limit of earth disturbance within the project\r\n        site."
                                   id="cb-5-c" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>c. 102.4(b)(5)(iii) – The Drawing(s) include the limit of earth disturbance within the project site.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. 102.4(b)(5)(v) – The Drawing(s) show receiving surface water(s) and watershed\r\n        boundaries, if applicable, within the project site and floodway or floodplain."
                                   id="cb-5-d" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>d. 102.4(b)(5)(v) – The Drawing(s) show receiving surface water(s) and watershed boundaries, if applicable, within the project site and flood way or floodplain.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. 102.4(b)(5)(ix) – The Drawing(s) identify all discharge points."
                                   id="cb-5-e" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>e. 102.4(b)(5)(ix) – The Drawing(s) identify all discharge points.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. 102.4(b)(5)(vi) – The Drawing(s) show the location of all BMPs and drainage areas to the\r\n        BMPs as applicable."
                                   id="cb-5-f" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>f. 102.4(b)(5)(vi) – The Drawing(s) show the location of all BMPs and drainage areas to the BMPs as applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. 102.4(b)(5)(iii) – The Drawing(s) show existing and proposed utilities and site\r\n        improvements."
                                   id="cb-5-g" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>g. 102.4(b)(5)(iii) – The Drawing(s) show existing and proposed utilities and site improvements.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. 102.4(b)(5)(xv) – The Drawing(s) show existing and proposed riparian buffer(s), if\r\n        applicable."
                                   id="cb-5-h" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>h. 102.4(b)(5)(xv) – The Drawing(s) show existing and proposed riparian buffer(s), if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. 102.4(b)(5)(iii) – The Drawing(s) show proposed off-site support activities, if applicable."
                                   id="cb-5-i" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>i. 102.4(b)(5)(iii) – The Drawing(s) show proposed off-site support activities, if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-j">
                            <input type="checkbox" class="cbi cbic"
                                   value="j. 102.4(c) – The Drawing(s) show the Avoidance Measures specified on the signed PNDI\r\n        receipt, if applicable. 2"
                                   id="cb-5-j" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>j. 102.4(c) – The Drawing(s) show the Avoidance Measures specified on the signed PNDI receipt, if applicable. 2

                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-k">
                            <input type="checkbox" class="cbi cbic"
                                   value="k. 102.4(b)(5)(vii) – The Drawing(s) provide for protection of infiltration PCSM BMPs until\r\n        drainage areas are completely stabilized, if applicable."
                                   id="cb-5-k" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>k. 102.4(b)(5)(vii) – The Drawing(s) provide for protection of infiltration PCSM BMPs until drainage areas are completely stabilized, if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-l">
                            <input type="checkbox" class="cbi cbic"
                                   value="l. 102.4(b)(5)(vii) & 102.4(b)(5)(xii) – The Drawing(s) show the sequence of construction,\r\n        an operation and maintenance (O&M) program, and procedures for recycling or disposing\r\n        of materials (not necessary if a separate narrative is attached).\r\n\r"
                                   id="cb-5-l" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>l. 102.4(b)(5)(vii) & 102.4(b)(5)(xii) – The Drawing(s) show the sequence of construction, an operation and maintenance (O&M) program, and procedures for recycling or disposing of materials (not necessary if a separate narrative is attached).

                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-6">
                    <input type="checkbox" class="cbi"
                           value="6. 102.6(a)(1) – One original and one copy of the complete PCSM Module 2 (3800-PM-\r\n     BCW0406b) were submitted and were completed as instructed in the PAG-02 NOI\r\n     Instructions.\r"
                           id="cb-6" name="options[]"> <i class="ml-1"></i>6. 102.6(a)(1) – One original and one copy of the complete PCSM Module 2 (3800-PM-BCW0406b) were submitted and were completed as instructed in the PAG-02 NOI Instructions.
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. 102.8(n) – The project qualifies as a Site Restoration Project. 3"
                                   id="cb-6-a" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>a. 102.8(n) – The project qualifies as a Site Restoration Project. 3
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. 102.8(g)(1) – A pre-development site characterization was provided (i.e., soils and\r\n        geotechnical testing results and narrative of methods and results)."
                                   id="cb-6-b" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>b. 102.8(g)(1) – A pre-development site characterization was provided (i.e., soils and geotechnical testing results and narrative of methods and results).
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. 102.8(g)(1) – Soil/geologic test results were attached."
                                   id="cb-6-c" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>c. 102.8(g)(1) – Soil/geologic test results were attached.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet –\r\n        Volume Worksheet was attached. 4"
                                   id="cb-6-d" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>d. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet – Volume Worksheet was attached. 4
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Stormwater Analysis – Runoff Volume\r\n        Questions 5 – 9 were answered and supporting calculations were provided. 4"
                                   id="cb-6-e" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>e. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Stormwater Analysis – Runoff Volume Questions 5 – 9 were answered and supporting calculations were provided. 4
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. 102.8(f)(8), 102.8(g)(3) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet – Rate\r\n        Worksheet was attached. 5"
                                   id="cb-6-f" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>f. 102.8(f)(8), 102.8(g)(3) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet – Rate Worksheet was attached. 5
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. 102.8(f)(8), 102.8(g)(3) & 102.8(g)(4) – Stormwater Analysis – Peak Rate Questions\r\n        5 – 9 were answered and supporting calculations were provided. 5"
                                   id="cb-6-g" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>g. 102.8(f)(8), 102.8(g)(3) & 102.8(g)(4) – Stormwater Analysis – Peak Rate Questions 5 – 9 were answered and supporting calculations were provided. 5
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet –\r\n        Quality Worksheet was attached."
                                   id="cb-6-h" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>h. 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4) – Printout of DEP’s PCSM Spreadsheet – Quality Worksheet was attached.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. 102.11(b) – If Managed Release Concept (MRC) BMPs were proposed, MRC Design\r\n        Summary Sheets were provided for each BMP and were sealed by a professional\r\n\r"
                                   id="cb-6-i" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>i. 102.11(b) – If Managed Release Concept (MRC) BMPs were proposed, MRC Design Summary Sheets were provided for each BMP and were sealed by a professional
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-7">
                    <input type="checkbox" class="cbi"
                           value="7. 102.8(f)(9) – Two sets or copies of PCSM Plan Drawing(s) were submitted.\r"
                           id="cb-7" name="options[]"> <i class="ml-1"></i>7. 102.8(f)(9) – Two sets or copies of PCSM Plan Drawing(s) were submitted.
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. 102.8(f)(1) – The Drawing(s) include existing and proposed topography with appropriate\r\n        contour labels."
                                   id="cb-7-a" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>a. 102.8(f)(1) – The Drawing(s) include existing and proposed topography with appropriate contour labels.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. 102.8(f)(3) – The Drawing(s) include the project site boundary."
                                   id="cb-7-b" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>b. 102.8(f)(3) – The Drawing(s) include the project site boundary.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. 102.8(f)(3) – The Drawing(s) include the limit of earth disturbance within the project site."
                                   id="cb-7-c" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>c. 102.8(f)(3) – The Drawing(s) include the limit of earth disturbance within the project site.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. 102.8(f)(5) – The Drawing(s) show receiving surface water(s) and watershed boundaries,\r\n        if applicable, within the project site and flood way or floodplain."
                                   id="cb-7-d" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>d. 102.8(f)(5) – The Drawing(s) show receiving surface water(s) and watershed boundaries, if applicable, within the project site and flood way or floodplain.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. 102.8(f)(9) – The Drawing(s) identify all discharge points."
                                   id="cb-7-e" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>e. 102.8(f)(9) – The Drawing(s) identify all discharge points.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. 102.8(f)(6) – The Drawing(s) show the location of all BMPs with identifiers cross-\r\n        referenced to PCSM Module 2."
                                   id="cb-7-f" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>f. 102.8(f)(6) – The Drawing(s) show the location of all BMPs with identifiers cross-referenced to PCSM Module 2.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. 102.8(f)(9) – Details were provided for all PCSM BMPs (required for any PCSM BMP\r\n        identified in Question 1 of PCSM Plan Information)."
                                   id="cb-7-g" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>g. 102.8(f)(9) – Details were provided for all PCSM BMPs (required for any PCSM BMP identified in Question 1 of PCSM Plan Information).
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. 102.8(f)(3) – The Drawing(s) show existing and proposed utilities and site improvements."
                                   id="cb-7-h" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>h. 102.8(f)(3) – The Drawing(s) show existing and proposed utilities and site improvements.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. 102.8(f)(14) – The Drawing(s) show existing and proposed riparian buffer(s), if applicable."
                                   id="cb-7-i" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>i. 102.8(f)(14) – The Drawing(s) show existing and proposed riparian buffer(s), if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-j">
                            <input type="checkbox" class="cbi cbic"
                                   value="j. 102.8(f)(3) – The Drawing(s) show proposed off-site support activities, if applicable."
                                   id="cb-7-j" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>j. 102.8(f)(3) – The Drawing(s) show proposed off-site support activities, if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-k">
                            <input type="checkbox" class="cbi cbic"
                                   value="k. 102.8(f)(15) – The Drawing(s) show the Avoidance Measures specified on the signed\r\n        PNDI receipt, if applicable. 2"
                                   id="cb-7-k" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>k. 102.8(f)(15) – The Drawing(s) show the Avoidance Measures specified on the signed PNDI receipt, if applicable. 2
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-l">
                            <input type="checkbox" class="cbi cbic"
                                   value="l. 102.8(f)(7) & 102.8(f)(10) – The Drawing(s) show the sequence of PCSM BMP\r\n        implementation, a long-term operation and maintenance (O&M) schedule, procedures for\r\n        recycling or disposing of materials, and critical stages of BMP implementation\r\n        (not necessary if a separate narrative is attached)."
                                   id="cb-7-l" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>l. 102.8(f)(7) & 102.8(f)(10) – The Drawing(s) show the sequence of PCSM BMP implementation, a long-term operation and maintenance (O&M) schedule, procedures for recycling or disposing of materials, and critical stages of BMP implementation (not necessary if a separate narrative is attached).
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-m">
                            <input type="checkbox" class="cbi cbic"
                                   value="m. 102.8(f)(2) – The Drawing(s) show sensitive features including sinkholes, surface\r\n        depressions, soil contamination hot spots, and wetlands, if applicable."
                                   id="cb-7-m" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>m. 102.8(f)(2) – The Drawing(s) show sensitive features including sinkholes, surface depressions, soil contamination hot spots, and wetlands, if applicable.
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-n">
                            <input type="checkbox" class="cbi cbic"
                                   value="n. 102.8(g)(1) – The Drawing(s) show the location of test pits used for infiltration testing\r\n        as cross-referenced to PCSM Module 2, Infiltration Information.\r"
                                   id="cb-7-n" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>n. 102.8(g)(1) – The Drawing(s) show the location of test pits used for infiltration testing as cross-referenced to PCSM Module 2, Infiltration Information.
                        </label>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>
