$(document).ready(function() {

    function calculateGeneratePrice() {
        // Directly select elements by their classes
        let shaxarsozlikUmumiyXajmi = parseFloat(document.querySelector('.shaxarsozlik_umumiy_xajmi')
            .value) || 0;
        let qavatlarSoniXajmi = parseFloat(document.querySelector('.qavatlar_soni_xajmi').value) || 0;
        let avtoturargohXajmi = parseFloat(document.querySelector('.avtoturargoh_xajmi').value) || 0;
        let umumiyFoydalanishdagiXajmi = parseFloat(document.querySelector('.umumiy_foydalanishdagi_xajmi')
            .value) || 0;
        let qavatXonaXajmi = parseFloat(document.querySelector('.qavat_xona_xajmi').value) || 0;

        let companyKubmetr = (shaxarsozlikUmumiyXajmi + qavatlarSoniXajmi) - (avtoturargohXajmi +
            umumiyFoydalanishdagiXajmi + qavatXonaXajmi);
        document.querySelector('.branch_kubmetr').value = companyKubmetr.toFixed(2);

        let minimumWageElement = document.querySelector('.minimum_wage');
        let minimumWage = parseFloat(minimumWageElement.value) || 340000;
        let coefficient = parseFloat(document.querySelector('.coefficient').value) || 1;
        let adjustedMinimumWage = 340000 * coefficient;

        document.querySelector('.minimum_wage').value = adjustedMinimumWage.toFixed(2);

        let generatePrice = companyKubmetr * adjustedMinimumWage;
        document.querySelector('.generate_price').value = generatePrice.toFixed(2);

        let percentageInput = parseFloat(document.querySelector('.percentage-input').value) || 0;
        let quarterlyInput = parseInt(document.querySelector('.quarterly-input').value) || 0;

        if (!isNaN(generatePrice)) {
            let z = (generatePrice * percentageInput) / 100;
            document.querySelector('.first_payment_percent').value = z.toFixed(2);

            if (!isNaN(percentageInput) && !isNaN(quarterlyInput) && quarterlyInput > 0) {
                let n = generatePrice - z;
                let y = n / quarterlyInput;
                document.querySelector('.calculated-quarterly-payment').value = y.toFixed(2);
                updateQuarterlyPaymentSchedule(y, quarterlyInput);
            } else {
                document.querySelector('.calculated-quarterly-payment').value = '';
                updateQuarterlyPaymentSchedule('', '');
            }

            updatePaymentSchedule(generatePrice);
        }
    }

    // Function to update payment schedule
    function updatePaymentSchedule(generatePrice) {
        let paymentSchedule = $('.payment-schedule');
        paymentSchedule.empty();
        let percentages = [0, 10, 20, 30, 40, 50];
        percentages.forEach(percentage => {
            let z = Math.round((generatePrice * percentage) / 100);
            let n = generatePrice - z;
            let quarterlyInput = $('.quarterly-input').val();
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
    function updateQuarterlyPaymentSchedule(quarterlyPayment, quarterlyInput) {
        let quarterlySchedule = $('.quarterly-payment-schedule');
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
            calculateGeneratePrice();
        });

    // Event listener for percentage-input changes
    $(document).on('input change', '.percentage-input', function() {
        calculateGeneratePrice();
    });

    // Event listener for quarterly-input changes
    $(document).on('input change', '.quarterly-input', function() {
        let quarterlyInput = parseInt($(this).val()) || 0;
        let generatePrice = parseFloat($('.generate_price').val()) || 0;
        let percentageInput = parseFloat($('.percentage-input').val()) || 0;
        let z = (generatePrice * percentageInput) / 100;

        if (!isNaN(generatePrice) && !isNaN(percentageInput) && quarterlyInput > 0) {
            let n = generatePrice - z;
            let y = n / quarterlyInput;
            $('.calculated-quarterly-payment').val(y.toFixed(2));
            updateQuarterlyPaymentSchedule(y, quarterlyInput);
        } else {
            $('.calculated-quarterly-payment').val('');
            updateQuarterlyPaymentSchedule('', '');
        }
    });

    // Event listener for payment type changes
    $(document).on('change', '.payment-type', function() {
        let paymentType = $(this).val();
        let percentageInput = $('.percentage-input');
        let quarterlyInput = $('.quarterly-input');

        if (paymentType === 'pay_full') {
            percentageInput.val(100).prop('disabled', true);
            quarterlyInput.val('').prop('disabled', true);
            $('.calculated-quarterly-payment').val('N/A');
            $('.payment-schedule').empty();
            $('.quarterly-payment-schedule').empty();
        } else {
            percentageInput.prop('disabled', false);
            quarterlyInput.prop('disabled', false);
        }

        calculateGeneratePrice();
    });

    // Event listener for coefficient changes
    $(document).on('input change', '.coefficient', function() {
        calculateGeneratePrice();
    });

    // Function to calculate the coefficient and update it in the accordion items
    function calculateCoefficient() {
        var coefficient = 1;
        var totalKts = [];
        var selectElements = document.querySelectorAll('.form_select_cof');

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

        calculateGeneratePrice(); // Recalculate minimum wage and other values
    }

    $('.form_select_cof').on('change', calculateCoefficient);

    // Initial coefficient calculation
    calculateCoefficient();
});