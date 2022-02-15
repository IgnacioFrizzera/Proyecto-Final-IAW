const receiptLongNameTypes = ['Factura', 'Factura C.C', 'Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito'];
const receiptColors = ['rgb(60, 179, 113)', 'rgb(255, 0, 0)', 'rgb(0, 0, 255)', 'rgb(255, 165, 0)', 'rgb(0, 0, 70)'];
const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

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

function makeSalesChart(currentMonthMovements, lastYearSales, currentYearSales) {
    const soldVsPaidBarChart = document.getElementById('soldVsPaidBarChart');
    const soldWithPromotionPieChart = document.getElementById('soldWithPromotionPieChart');
    const lastYearSalesComparisonBarChart = document.getElementById('lastYearSalesComparisonBarChart');
    
    const today = new Date();
    const currentMonth = today.getMonth() + 1;
    const currentYear = today.getFullYear();
    const lastYear = currentYear - 1;

    const totalMovements = currentMonthMovements.length;
    var sold = 0;
    var paid = 0;
    var soldWithPromotion = 0;

    for (let movement of currentMonthMovements) {
        sold += parseFloat(movement.due);
        paid += parseFloat(movement.paid);
        if (movement.receipt_type == "FC" || movement.receipt_type == "FCC") {
            if (movement.paid_with_promotion) {
                soldWithPromotion += 1;
            }
        }
    }

    const soldVsPaidBarChartData = [sold, paid];
    const soldVsPaidBarChartAxesData = [
        {
            x: ['Vendido', 'Pagado'],
            y: soldVsPaidBarChartData,
            marker:{
                color: receiptColors
            },
            type: 'bar'
        }
    ];

    const soldVsPaidBarChartLayout = {
        title: 'Vendido vs Pagado del mes actual'
    };

    Plotly.newPlot(soldVsPaidBarChart, soldVsPaidBarChartAxesData, soldVsPaidBarChartLayout, {staticPlot: true});

    const soldWithPromotionPercentagesData = [soldWithPromotion/totalMovements, (totalMovements-soldWithPromotion) / totalMovements];
    const pieChartData = [
        {
            values: soldWithPromotionPercentagesData,
            labels: ['Venta con promoción', 'Venta sin promoción'],
            type: 'pie',
            textinfo: "label+percent",
            textposition: "inside",
        }
    ];

    const pieChartLayout = {
        title: 'Porcentaje de ventas por promoción del mes actual',
        heigh: 400,
        width: 500
    };

    Plotly.newPlot(soldWithPromotionPieChart, pieChartData, pieChartLayout, {staticPlot: true});


    const lastYearSalesPerMonth = {}
    const currentYearSalesPerMonth = {};
    for (let i = 1; i < 13; i++) {
        lastYearSalesPerMonth[i] = 0;
        if (i == currentMonth) {
            currentYearSalesPerMonth[i] = sold;
        }
        else {
            currentYearSalesPerMonth[i] = 0;
        }
    }
    
    for (let sale of lastYearSales) {
        lastYearSalesPerMonth[sale.month] = parseFloat(sale.fc) + parseFloat(sale.fcc);
    }
        
    for (let sale of currentYearSales) {
        currentYearSalesPerMonth[sale.month] = parseFloat(sale.fc) + parseFloat(sale.fcc);
    }

    const lastYearData = {
        x: months,
        y: Object.values(lastYearSalesPerMonth),
        name: lastYear,
        type: 'bar'
    };

    const currentYearData = {
        x: months,
        y: Object.values(currentYearSalesPerMonth),
        name: currentYear,
        type: 'bar'
    }

    const yearComparisonData = [lastYearData, currentYearData];

    const yearComparisonLayout = {title:'Comparación ventas años: ' + lastYear + '-' + currentYear, barmode: 'group'};
      
    Plotly.newPlot(lastYearSalesComparisonBarChart, yearComparisonData, yearComparisonLayout, {displayModeBar: false});
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

    Plotly.newPlot(movementsBarChart, barChartData, barChartLayout, {staticPlot: true});

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

    Plotly.newPlot(barChart, barChartData, barChartLayout, {staticPlot: true});

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

separateMovements(ChartNamespace.movements);
makeSalesChart(ChartNamespace.currentMonthMovements, ChartNamespace.lastYearSales, ChartNamespace.currentYearSales);
makeMovementsChart(ChartNamespace.movements.length);
makeLabelsChart(ChartNamespace.movements);