# Hypertension Management via OpenEMR Integration

This project presents a clinical decision support workflow for identifying and managing patients at risk of hypertension using OpenEMR, Synthea-generated patient data, and Tableau analytics.

## Project Overview

Hypertension is a critical public health issue, affecting nearly half of all American adults. Our goal was to develop an early-intervention care plan targeting patients **without a formal hypertension diagnosis** but exhibiting **elevated blood pressure** in outpatient visits.

## Objectives

* Identify at-risk individuals using Synthea-generated cohorts.
* Detect elevated BP readings in non-hypertensive patients.
* Develop and implement an **automated alert system** and **care plan workflow** within OpenEMR.
* Evaluate the effectiveness of the intervention using Tableau visualizations.

## Workflow Summary

1. **Cohort Selection**

   * Criteria:

     * No ICD9 diagnosis codes (400–404)
     * Not currently prescribed antihypertensive medication
     * Elevated BP in outpatient/wellness visit vitals

2. **Clinical Rule Trigger**

   * Flag patients with ≥3 high BP readings in the past year
   * Alert clinicians through OpenEMR

3. **Care Plan Assignment**

   * Use a standardized care plan focused on lifestyle changes
   * Schedule follow-ups every 2 months
   * Track outcomes: medication initiation, risk scores, visit frequency, and BP changes

4. **Data Visualization**

   * Use Tableau to analyze demographics, medication outcomes, and care plan effectiveness

##  Tech Stack

* **Synthea** – Synthetic patient data generation
* **OpenEMR** – EMR platform integration, HTN Assessment with Javascript 
* **Tableau** – Data analysis and visualization

## Outcomes and Considerations

* Risk scoring system needs refinement to include social determinants of health
* Observed challenges:

  * Patients with normalized BP missed follow-ups
  * Lower-income groups had more difficulty adhering to the care plan
* Proposed enhancements:

  * Interactive care plans and appointment automation
  * Built-in nutritionist referrals
  * Self-reinforcing EMR notifications

## Future Directions

* Broaden rule criteria to include lab values and chronic stress indicators
* Automate care escalation based on ongoing vitals and lifestyle adherence
* Incorporate cost-saving initiatives (e.g., process automation)
