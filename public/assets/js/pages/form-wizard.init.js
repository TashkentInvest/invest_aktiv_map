// $(function () {
//     $("#basic-example").steps({
//         headerTag: "h3",
//         bodyTag: "section",
//         transitionEffect: "slide",
//     }),
//         $("#vertical-example").steps({
//             headerTag: "h3",
//             bodyTag: "section",
//             transitionEffect: "slide",
//             stepsOrientation: "vertical",
//         });
// });

$(function () {
    $("#basic-example").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        autoFocus: true,
        stepsOrientation: "vertical",
        labels: {
            next: "Следующий шаг", // Change this to your desired text
            previous: "Предыдущий шаг" // Change this to your desired text
        },
    }),
    $("#vertical-example").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        autoFocus: true,
        stepsOrientation: "vertical",
        labels: {
            next: "Следующий шаг", // Change this to your desired text
            previous: "Предыдущий шаг" // Change this to your desired text
        },
        onStepChanged: function(event, currentIndex, priorIndex) {
            // Hide the finish button
            const finishButton = $("a[href='#finish']");
            if (finishButton) {
                finishButton.hide();
            }
        }
    });
});
