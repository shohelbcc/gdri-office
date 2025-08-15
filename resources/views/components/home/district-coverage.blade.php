<!-- District Coverage Section Start -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

<div class="container-fluid py-5" style="overflow-x:hidden;max-width:100vw;">
    <div class="container" style="overflow-x:hidden;max-width:100vw;">
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="section_title_light mb-4">District Coverage Across Bangladesh</h1>
            <p class="fw-bold">Geological Survey of Bangladesh serves across multiple districts with our specialized
                offices and field stations.</p>
        </div>

        <div class="row wow fadeInUp" data-wow-delay="0.1s">
            <!-- District Map Column -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                            <h4 class="mb-3">About Our District Coverage</h4>
                            <p class="text-justify">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Impedit sapiente, quidem quos
                                aliquid rem consequuntur perferendis at rerum odio, ducimus, cum commodi ab a quaerat
                                eaque fugit ex unde assumenda molestias perspiciatis. Sequi itaque assumenda natus
                                deleniti asperiores aut. Nobis soluta rerum, magni nesciunt accusamus nihil ducimus
                                nostrum assumenda natus dolores voluptatibus sed laborum? Tempore quod ea, maxime quam
                                commodi reprehenderit dolor, esse temporibus fugit dolores dolorum, modi quasi iste.
                                Tempore est repudiandae eveniet commodi veniam sed officiis rem, tempora nostrum
                                dolorum! Pariatur possimus inventore culpa, harum veniam repellendus alias esse facere,
                                dolorem nihil ratione. Voluptate cupiditate odio dicta beatae molestiae enim architecto
                                deleniti quibusdam magni nisi! Voluptate sed, nihil necessitatibus ipsum voluptatum
                                tempore modi odio iusto assumenda asperiores error.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <div id="map" style="width:100%;height: 600px;max-width:100vw;overflow-x:hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .leaflet-bar.leaflet-control.leaflet-control-custom {
        background-color: white;
        width: 34px;
        height: 34px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Map District Hover Effects */
    .district-polygon {
        cursor: pointer !important;
        transition: all 0.3s ease;
    }

    .custom-tooltip {
        background: rgba(0, 0, 0, 0.8) !important;
        border: none !important;
        border-radius: 6px !important;
        color: white !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        padding: 8px 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
    }

    .custom-tooltip:before {
        border-top-color: rgba(0, 0, 0, 0.8) !important;
    }

    /* Map container styling */
    #map {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 100vw;
        overflow-x: hidden;
    }
</style>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    try {
        // 1) ম্যাপ ইনিশিয়ালাইজ
        var defaultCenter = [23.8, 90.3];
        var defaultZoom = 7;
        var map = L.map('map', {
            zoomControl: true,
            attributionControl: false,
            scrollWheelZoom: false
        }).setView(defaultCenter, defaultZoom);

        // Custom Zoom Reset Control
        var ZoomResetControl = L.Control.extend({
            options: { position: 'topleft' },
            onAdd: function (map) {
                var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                container.style.backgroundColor = 'white';
                container.style.width = '34px';
                container.style.height = '34px';
                container.style.cursor = 'pointer';
                container.title = 'Reset Zoom';
                container.innerHTML = '<i class="fas fa-compress-arrows-alt" style="line-height:34px;font-size:18px;color:#4d4d4d;text-align:center;width:100%;"></i>';
                container.onclick = function () {
                    map.setView(defaultCenter, defaultZoom);
                };
                return container;
            }
        });
        map.addControl(new ZoomResetControl());

        // 2) Base layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            minZoom: 6,
            maxZoom: 12
        }).addTo(map);



        // 3) GSB কভারড জেলাসমূহ
        var coveredDistricts = @json(getCoveredDistricts());

        // 4) বিশ্ব মাস্ক
        var worldBounds = [[-90, -180], [-90, 180], [90, 180], [90, -180]];

        // 5) GeoJSON লোড (rawcdn.githack.com দিয়ে CORS support)
        fetch('https://rawcdn.githack.com/nuhil/bangladesh-geocode/master/geojson/districts.geojson')
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok: ' + res.status);
                return res.json();
            })
            .then(geojson => {
                // 6) বাংলাদেশ রিংগুলো এক্সট্রাক্ট
                var bdRings = [];
                geojson.features.forEach(f => {
                    var g = f.geometry;
                    if (g.type === 'Polygon') {
                        g.coordinates.forEach(r => bdRings.push(r.map(pt => [pt[1], pt[0]])));
                    } else {
                        g.coordinates.forEach(poly =>
                            poly.forEach(r => bdRings.push(r.map(pt => [pt[1], pt[0]])))
                        );
                    }
                });

                // 7) বাইরের মাস্ক আঁকো
                L.polygon([worldBounds].concat(bdRings), {
                    stroke: false,
                    fillColor: '#00000099',
                    fillOpacity: 1,
                    fillRule: 'evenodd',
                    interactive: false
                }).addTo(map);

                // 8) জেলা লেয়ার
                var districtLayer = L.geoJSON(geojson, {
                    style(feature) {
                        // সব possible properties check করো
                        var props = feature.properties;
                        var raw = props.DISTRICT || props.NAME || props.name || props.NAME_EN || props.ADM2_EN || props.district || '';
                        var name = raw.replace(/ District$/, '').replace(/ Zila$/, '').trim();
                        var key = name.toLowerCase();

                        // Debug: console এ সব properties এবং district names দেখাও
                        // console.log('All properties:', props);
                        // console.log('District found:', name, 'Key:', key);

                        var covered = coveredDistricts.includes(key);
                        // console.log('Is covered:', covered);

                        return {
                            fillColor: covered ? '#28a745' : '#cccccc',
                            weight: 2,
                            color: '#ffffff',
                            fillOpacity: 0.8,
                            // Hover এর জন্য cursor pointer
                            className: 'district-polygon'
                        };
                    },
                    onEachFeature(feature, layer) {
                        var props = feature.properties;
                        var raw = props.DISTRICT || props.NAME || props.name || props.NAME_EN || props.ADM2_EN || props.district || 'Unknown';
                        var name = raw.replace(/ District$/, '').replace(/ Zila$/, '').trim();
                        var covered = coveredDistricts.includes(name.toLowerCase());
                        var status = covered ? 'GSB Office Active' : 'Coming Soon';
                        var color = covered ? '🟢' : '⏳';

                        // যদি name empty হয় তাহলে fallback
                        if (!name || name === '') {
                            name = 'Unknown District';
                        }

                        // Tooltip
                        layer.bindTooltip(`${color} ${name} - ${status}`, {
                            permanent: false,
                            direction: 'center',
                            className: 'custom-tooltip'
                        });

                        // Hover effects
                        layer.on({
                            mouseover: function (e) {
                                var hoverLayer = e.target;
                                hoverLayer.setStyle({
                                    fillColor: '#ffa500',  // হালকা অরেঞ্জ কালার
                                    fillOpacity: 0.8
                                });
                                hoverLayer.bringToFront();
                            },
                            mouseout: function (e) {
                                var hoverLayer = e.target;
                                hoverLayer.setStyle({
                                    fillColor: covered ? '#28a745' : '#cccccc',
                                    fillOpacity: 0.8
                                });
                            }
                        });
                    }
                }).addTo(map);

                // 9) ভিউ ফিট এবং লক
                var bdBounds = districtLayer.getBounds();
                map.fitBounds(bdBounds);
                map.setMaxBounds(bdBounds.pad(0.1));
                map.setMinZoom(map.getZoom());
            })
            .catch(err => {
                console.error('GeoJSON ফেচে এরর:', err);
                alert('GeoJSON লোডে সমস্যা: ' + err.message);
            });
    } catch (e) {
        console.error('Unexpected error:', e);
        alert('Unexpected JS error: ' + e.message);
    }
</script>

<!-- District Coverage Section End -->