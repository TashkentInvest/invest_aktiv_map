! function(a) {
    "use strict";

    function n() {}

    n.prototype.init = function() {
        a("#world-map-markers").vectorMap({
            map: "world_mill_en",
            normalizeFunction: "polynomial",
            hoverOpacity: 0.7,
            hoverColor: false,
            regionStyle: {
                initial: {
                    fill: "#d4dadd"
                }
            },
            markerStyle: {
                initial: {
                    r: 9,
                    fill: "#556ee6",
                    "fill-opacity": 0.9,
                    stroke: "#fff",
                    "stroke-width": 7,
                    "stroke-opacity": 0.4
                },
                hover: {
                    stroke: "#fff",
                    "fill-opacity": 1,
                    "stroke-width": 1.5
                }
            },
            backgroundColor: "transparent",
            markers: [{
                latLng: [41.311081, 69.240562], // Coordinates for Uzbekistan
                name: "Uzbekistan"
            }]
        });

        // Initialize other maps if needed
        a("#usa-vectormap").vectorMap({
            map: "us_merc_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });

        a("#india-vectormap").vectorMap({
            map: "in_mill_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });

        a("#australia-vectormap").vectorMap({
            map: "au_mill_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });

        a("#chicago-vectormap").vectorMap({
            map: "us-il-chicago_mill_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });

        a("#uk-vectormap").vectorMap({
            map: "uk_mill_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });

        a("#canada-vectormap").vectorMap({
            map: "ca_lcc_en",
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: "#556ee6"
                }
            }
        });
    };

    a.VectorMap = new n;
    a.VectorMap.Constructor = n;
}(window.jQuery);

(function() {
    "use strict";
    window.jQuery.VectorMap.init();
})();