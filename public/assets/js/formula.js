$(document).ready(function() {
    let accordionCount = 1;

    // Function to add a new accordion item
    $('#addAccordion').on('click', function() {
        let accordion = $('.accordion-item').first().clone();
        let newId = 'flush-collapse' + accordionCount;
        accordion.find('.accordion-collapse').attr('id', newId);
        accordion.find('.accordion-button').attr('data-bs-target', '#' + newId);
        accordion.find('.accordion-header').attr('id', 'flush-heading' + accordionCount);
        accordion.find('.accordion-button').attr('aria-controls', newId);
        accordion.find('.accordion-button').text('Объект #' + accordionCount);

        // Update input, select, and textarea names and ids
        accordion.find('input, select, textarea').each(function() {
            let name = $(this).attr('name');
            if (name) {
                let newName = name.replace(/\[0\]/, '[' + accordionCount + ']');
                $(this).attr('name', newName);
            }
            $(this).val('');
            $(this).attr('id', name + '-' + accordionCount);
        });

        // Update table and schedule ids
        let tableId = 'payment-table-' + accordionCount;
        let scheduleId = 'payment-schedule-' + accordionCount;
        let quarterlyTableId = 'quarterly-table-' + accordionCount;
        let quarterlyScheduleId = 'quarterly-schedule-' + accordionCount;

        accordion.find('.payment-table').attr('id', tableId);
        accordion.find('.payment-schedule').attr('id', scheduleId);
        accordion.find('.quarterly-table').attr('id', quarterlyTableId);
        accordion.find('.quarterly-payment-schedule').attr('id', quarterlyScheduleId);

        accordion.appendTo('#accordionFlushExample');
        accordionCount++;

        // Reset values and trigger changes
        accordion.find('.generate_price').val('');
        accordion.find('.payment-type').val('pay_full').trigger('change');
        accordion.find('.percentage-input').val('0').prop('disabled', true);
        accordion.find('.quarterly-input').val('').prop('disabled', true);
        accordion.find('.calculated-quarterly-payment').val('');
        accordion.find('.payment-schedule').empty();
        accordion.find('.quarterly-payment-schedule').empty();
        accordion.find('.total-quarterly-payment').text('0.00');

        // Initial calculation for the new accordion item
        calculateGeneratePrice(accordion.find('.accordion-body'));
    });

    // Function to calculate and update prices
    function calculateGeneratePrice(parentAccordion) {
        let shaxarsozlik_umumiy_xajmi = parseFloat(parentAccordion.find('.shaxarsozlik_umumiy_xajmi')
            .val()) || 0;
        let qavatlar_soni_xajmi = parseFloat(parentAccordion.find('.qavatlar_soni_xajmi').val()) || 0;
        let avtoturargoh_xajmi = parseFloat(parentAccordion.find('.avtoturargoh_xajmi').val()) || 0;
        let umumiy_foydalanishdagi_xajmi = parseFloat(parentAccordion.find('.umumiy_foydalanishdagi_xajmi')
            .val()) || 0;
        let qavat_xona_xajmi = parseFloat(parentAccordion.find('.qavat_xona_xajmi').val()) || 0;

        let companyKubmetr = (shaxarsozlik_umumiy_xajmi + qavatlar_soni_xajmi) - (avtoturargoh_xajmi +
            umumiy_foydalanishdagi_xajmi + qavat_xona_xajmi);
        parentAccordion.find('.branch_kubmetr').val(companyKubmetr.toFixed(2));

        let minimumWage = parseFloat(parentAccordion.find('.minimum_wage').val()) ||
            340000; // Default or original value
        let coefficient = parseFloat(parentAccordion.find('.coefficient').val()) || 1;

        let adjustedMinimumWage = 340000 * coefficient;
        // let adjustedMinimumWage = minimumWage * coefficient;
        parentAccordion.find('.minimum_wage').val(adjustedMinimumWage.toFixed(2));

        let generatePrice = companyKubmetr * adjustedMinimumWage;
        parentAccordion.find('.generate_price').val(generatePrice.toFixed(2));

        let percentageInput = parseFloat(parentAccordion.find('.percentage-input').val()) || 0;
        let quarterlyInput = parseInt(parentAccordion.find('.quarterly-input').val()) || 0;

        // Separate the calculation for first_payment_percent
        if (!isNaN(generatePrice)) {
            let z = (generatePrice * percentageInput) / 100;
            parentAccordion.find('.first_payment_percent').val(z.toFixed(2));

            if (!isNaN(percentageInput) && !isNaN(quarterlyInput) && quarterlyInput > 0) {
                let n = generatePrice - z;
                let y = n / quarterlyInput;
                parentAccordion.find('.calculated-quarterly-payment').val(y.toFixed(2));
                updateQuarterlyPaymentSchedule(parentAccordion, y, quarterlyInput);
            } else {
                parentAccordion.find('.calculated-quarterly-payment').val('');
                updateQuarterlyPaymentSchedule(parentAccordion, '', '');
            }

            updatePaymentSchedule(parentAccordion, generatePrice);
        }
    }

    // Function to update payment schedule
    function updatePaymentSchedule(parentAccordion, generatePrice) {
        let paymentSchedule = parentAccordion.find('.payment-schedule');
        paymentSchedule.empty();
        let percentages = [0, 10, 20, 30, 40, 50];
        percentages.forEach(percentage => {
            let z = Math.round((generatePrice * percentage) / 100);
            let n = generatePrice - z;
            let quarterlyInput = parentAccordion.find('.quarterly-input').val();
            let y = quarterlyInput ? Math.round((n / quarterlyInput)) : "N/A";
            paymentSchedule.append(
                `<tr>
                            <td>${percentage}%</td>
                            <td>${Math.round(z)}</td>
                            <td>${y}</td>
                        </tr>`
            );
        });
    }

    // Function to update quarterly payment schedule
    function updateQuarterlyPaymentSchedule(parentAccordion, quarterlyPayment, quarterlyInput) {
        let quarterlySchedule = parentAccordion.find('.quarterly-payment-schedule');
        quarterlySchedule.empty();
        if (quarterlyPayment && quarterlyInput) {
            for (let i = 1; i <= quarterlyInput; i++) {
                quarterlySchedule.append(
                    `<tr>
                                <td>${i}</td>
                                <td>${quarterlyPayment.toFixed(2)}</td>
                            </tr>`
                );
            }
        }
    }

    // Event listener for input changes
    $(document).on('input change',
        '.branch_kubmetr, .minimum_wage, .shaxarsozlik_umumiy_xajmi, .qavatlar_soni_xajmi, .avtoturargoh_xajmi, .umumiy_foydalanishdagi_xajmi, .qavat_xona_xajmi, .obyekt_joylashuvi, .branch_type, .qurilish_turi, .zona',
        function() {
            let parentAccordion = $(this).closest('.accordion-body');
            calculateGeneratePrice(parentAccordion);
        });

    // Event listener for percentage-input changes
    $(document).on('input change', '.percentage-input', function() {
        let parentAccordion = $(this).closest('.accordion-body');
        calculateGeneratePrice(parentAccordion);
    });

    // Event listener for quarterly-input changes
    $(document).on('input change', '.quarterly-input', function() {
        let parentAccordion = $(this).closest('.accordion-body');
        let quarterlyInput = parseInt($(this).val()) || 0;
        let generatePrice = parseFloat(parentAccordion.find('.generate_price').val()) || 0;
        let percentageInput = parseFloat(parentAccordion.find('.percentage-input').val()) || 0;
        let z = (generatePrice * percentageInput) / 100;

        if (!isNaN(generatePrice) && !isNaN(percentageInput) && quarterlyInput > 0) {
            let n = generatePrice - z;
            let y = n / quarterlyInput;
            parentAccordion.find('.calculated-quarterly-payment').val(y.toFixed(2));
            updateQuarterlyPaymentSchedule(parentAccordion, y, quarterlyInput);
        } else {
            parentAccordion.find('.calculated-quarterly-payment').val('');
            updateQuarterlyPaymentSchedule(parentAccordion, '', '');
        }
    });

    // Event listener for payment type changes
    $(document).on('change', '.payment-type', function() {
        let parentAccordion = $(this).closest('.accordion-body');
        let paymentType = $(this).val();
        let percentageInput = parentAccordion.find('.percentage-input');
        let quarterlyInput = parentAccordion.find('.quarterly-input');

        if (paymentType === 'pay_full') {
            percentageInput.val(100).prop('disabled', true);
            quarterlyInput.val('').prop('disabled', true);
            parentAccordion.find('.calculated-quarterly-payment').val('N/A');
            parentAccordion.find('.payment-schedule').empty();
            parentAccordion.find('.quarterly-payment-schedule').empty();
        } else {
            percentageInput.prop('disabled', false);
            quarterlyInput.prop('disabled', false);
        }

        calculateGeneratePrice(parentAccordion);
    });

    // Event listener for coefficient changes
    $(document).on('input change', '.coefficient', function() {
        let parentAccordion = $(this).closest('.accordion-body');
        calculateGeneratePrice(parentAccordion);
    });

    // Function to calculate the coefficient and update it in the accordion items
    function calculateCoefficient() {
        var coefficient = 1;
        var totalKts = [];
        var selectElements = document.querySelectorAll('.select2');

        selectElements.forEach(function(select) {
            Array.from(select.selectedOptions).forEach(function(option) {
                var kt = parseFloat(option.dataset.kt);
                if (!isNaN(kt)) {
                    totalKts.push(kt);
                }
            });
        });

        if (totalKts.includes(0)) {
            coefficient = 0;
        } else if (totalKts.length === 0) {
            coefficient = 1;
        } else {
            totalKts.forEach(function(kt) {
                coefficient *= kt;
            });

            // Apply the limits
            if (coefficient < 0.50) {
                coefficient = 0.50;
            } else if (coefficient > 2.00) {
                coefficient = 2.00;
            }
        }

        document.querySelectorAll('.coefficient').forEach(function(coefficientInput) {
            coefficientInput.value = coefficient.toFixed(2);
        });

        document.querySelectorAll('.accordion-body').forEach(function(parentAccordion) {
            calculateGeneratePrice($(parentAccordion));
        });
    }


    $('.select2').on('change', calculateCoefficient);

    // Initial coefficient calculation
    calculateCoefficient();
});

