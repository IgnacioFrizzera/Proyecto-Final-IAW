const receiptShortNameValues = ['FC', 'FCC', 'EF', 'TC', 'TD'];
const receiptLongNameTypes = ['Factura', 'Factura C.C', 'Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito'];
const receiptColors = ['rgb(60, 179, 113)', 'rgb(255, 0, 0)', 'rgb(0, 0, 255)', 'rgb(255, 165, 0)', 'rgb(0, 0, 70)'];

// Only takes FC and FCC movements. Dict: <BrandName, AmountOfMovementsWithBrandName>
const brandsDict = {};
const categoriesDict = {};

// Sales
const fcMovements = [];
const fccMovements = [];

// Payments
const efMovements = [];
const tcMovements = [];
const tdMovements = [];

const receiptTypeTranslation = {
    'FC': 'Factura',
    'FCC': 'Factura Cuenta Corriente',
    'EF': 'Efectivo',
    'TC': 'Tarjeta de crédito',
    'TD': 'Tarjeta de débito'
};


function separateMovements(movements) {
    for (let movement of movements) {
        if (movement.receipt_type == 'FC') {
            fcMovements.push(movement);
        }
        if (movement.receipt_type == 'FCC') {
            fccMovements.push(movement);
        }
        if (movement.receipt_type == 'EF') {
            efMovements.push(movement);
        }
        if (movement.receipt_type == 'TC') {
            tcMovements.push(movement);
        }
        if (movement.receipt_type == 'TD') {
            tdMovements.push(movement);
        }
    }
}

function makeMovementsChart(totalMovements) {
    const movementsBarChart = document.getElementById('movementsBarChart');
    const movementsPieChart = document.getElementById('movementsPieChart');

    const movementsAmountData = [fcMovements.length, fccMovements.length, efMovements.length, tcMovements.length, tdMovements.length];

    const barChartData = [
        {
            x: receiptLongNameTypes,
            y: movementsAmountData,
            marker:{
                color: receiptColors
            },
            type: 'bar'
        }
    ];

    const barChartLayout = {
        title: 'Cantidad de movimientos por tipo de comprobante',
    };

    Plotly.newPlot(movementsBarChart, barChartData, barChartLayout);

    const movementsPercentagesData = [];
    for (movementAmount of movementsAmountData) {
        movementsPercentagesData.push(movementAmount / totalMovements);
    }

    const pieChartData = [
        {
            values: movementsPercentagesData,
            labels: receiptLongNameTypes,
            type: 'pie',
            textinfo: "label+percent",
            textposition: "inside",
        }
    ];

    const pieChartLayout = {
        title: 'Porcentaje de movimientos por tipo de comprobante',
        heigh: 400,
        width: 500
    };

    Plotly.newPlot(movementsPieChart, pieChartData, pieChartLayout, {staticPlot: true});
}

function makeLabelChart(label, totalMovements, data) {
    var barChart = null;
    var pieChart = null;
    var titleEnding = null;

    if (label == 'categories') {
        barChart = document.getElementById("categoriesBarChart");
        pieChart = document.getElementById("categoriesPieChart");
        titleEnding = 'categoría';
    }
    else if (label == 'brands') {
        barChart = document.getElementById("brandsBarChart");
        pieChart = document.getElementById("brandsPieChart");
        titleEnding = 'marca';
    }
    
    const barChartData = [
        {
            x: Object.keys(data),
            y: Object.values(data),
            type: 'bar'
        }
    ];

    const barChartLayout = {
        title: 'Cantidad de movimientos por ' + titleEnding,
    };

    Plotly.newPlot(barChart, barChartData, barChartLayout);

    const pieChartDataPercentages = [];
    for (let value of Object.values(data)) {
        pieChartDataPercentages.push(value / totalMovements);
    }

    const pieChartData = [
        {
            values: pieChartDataPercentages,
            labels: Object.keys(data),
            type: 'pie',
            textinfo: "label+percent",
            textposition: "inside",
        }
    ];

    const pieChartLayout = {
        title: 'Porcentaje de movimientos por ' + titleEnding,
        heigh: 400,
        width: 500
    };

    Plotly.newPlot(pieChart, pieChartData, pieChartLayout, {staticPlot: true});
}

function makeLabelsChart() {
    const salesMovements = fcMovements.concat(fccMovements);
    const totalSalesMovements = salesMovements.length;

    for (let saleMovement of salesMovements) {
        if (brandsDict[saleMovement.brand_name]) {
            brandsDict[saleMovement.brand_name] += 1;
        } else {
            brandsDict[saleMovement.brand_name] = 1;
        }

        if (categoriesDict[saleMovement.category_name]) {
            categoriesDict[saleMovement.category_name] += 1;
        } else {
            categoriesDict[saleMovement.category_name] = 1;
        }
    }

    makeLabelChart('brands', totalSalesMovements, brandsDict);
    makeLabelChart('categories', totalSalesMovements, categoriesDict);
}


// {
//     "receipt_type": "FC",
//     "due": "1500",
//     "paid": "0",
//     "category_name": "SWEATERS",
//     "brand_name": "PERRAMUS",
//     "paid_with_promotion": true,
//     "created_at": "2022-01-23T00:00:00.000000Z"
// }

separateMovements(ChartNamespace.movements);
makeMovementsChart(ChartNamespace.movements.length);
makeLabelsChart(ChartNamespace.movements);