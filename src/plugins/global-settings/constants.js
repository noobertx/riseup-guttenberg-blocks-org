export const ADDNEWDEFAULT = {
    name: undefined,
    key: undefined,
    colors: [],
    typography: [
        {
            name: 'Heading 1',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h1'
            }]
        },
        {
            name: 'Heading 2',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h2'
            }]
        },
        {
            name: 'Heading 3',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h3'
            }]
        },
        {
            name: 'Heading 4',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h4'
            }]
        },
        {
            name: 'Heading 5',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h5'
            }]
        },
        {
            name: 'Heading 6',
            value: {
                openTypography: 1,
            },
            style: [{
                selector: '{{WPRIG}} h6'
            }]
        }
    ],
}

export const DEFAULTPRESETS = {
    activePreset: 'preset1',
    presets: {
        preset1: {
            name: 'Preset #1',
            key: 'preset1',
            colors: ['#e36d60', '#41848f', '#c0392b', '#27ae60', '#2980b9', '#f1c40f','#1c2833','#95a5a6','ecf0f1','#ffffff','#00bcd4','#4caf50','#ff9800','#f44336' ],
            typography: [
                {
                    name: 'Heading 1',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        class_name:"wprig-heading-1",
                        size: {
                            md: 60,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "80"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: 'Heading 2',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        class_name:"wprig-heading-2",
                        size: {
                            md: 48,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "64"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: 'Heading 3',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        class_name:"wprig-heading-3",
                        size: {
                            md: 36,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "48"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: 'Heading 4',
                    scope: 'others',
                    value: {
                        class_name:"wprig-heading-4",
                        openTypography: 1,
                        size: {
                            md: 30,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "36"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: 'Heading 5',
                    scope: 'others',
                    value: {
                        class_name:"wprig-heading-5",
                        openTypography: 1,
                        size: {
                            md: 18,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "28"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: 'Heading 6',
                    scope: 'others',
                    value: {
                        class_name:"wprig-heading-6",
                        openTypography: 1,
                        size: {
                            md: 16,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "24"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: "Paragraph #1",
                    scope: 'p',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 18,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "24"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                    }
                },
                {
                    name: "Paragraph #2",
                    scope: 'p',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 14,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "22"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                    }
                },
                {
                    name: "Button #1",
                    scope: 'button',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 16,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "19"
                        },
                        spacing: {
                            unit: "px",
                            md: "3",
                            xs: "0"
                        },
                        type: "sans-serif",
                        transform: "uppercase",
                        weight: 700,
                    }
                },
                {
                    name: "Button #2",
                    scope: 'button',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 14,
                            unit: "px"
                        },
                        family: "Roboto",
                        height: {
                            unit: "px",
                            md: "19"
                        },
                        spacing: {
                            unit: "px",
                            md: "3",
                            xs: "0"
                        },
                        type: "sans-serif",
                        transform: "uppercase",
                        weight: 700,
                    }
                },

            ],
        },
        preset2: {
            name: 'Preset #2',
            key: 'preset2',
            colors: ['#0081FF', '#0053A4', '#363636', '#BBC0D4', '#FFFFFF'],
            typography: [
                {
                    name: 'Heading 1',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 60,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "71"
                        },
                        spacing: {
                            unit: "px",
                            md: "-2",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: 'Heading 2',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 48,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "58"
                        },
                        spacing: {
                            unit: "px",
                            md: "-0.5",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: 'Heading 3',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 36,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "44"
                        },
                        spacing: {
                            unit: "px",
                            md: "-0.35",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: 'Heading 4',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 30,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "36"
                        },
                        spacing: {
                            unit: "px",
                            md: "-0.31",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: 'Heading 5',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 26,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "34"
                        },
                        spacing: {
                            unit: "px",
                            md: "-0.25",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: 'Heading 6',
                    scope: 'others',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 22,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "32"
                        },
                        spacing: {
                            unit: "px",
                            md: "-0.21",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 300
                    }
                },
                {
                    name: "Paragraph #1",
                    scope: 'p',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 18,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "30"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 400
                    }
                },
                {
                    name: "Paragraph #2",
                    scope: 'p',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 14,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "22"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 400
                    }
                },
                {
                    name: "Button #1",
                    scope: 'button',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 16,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "19"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                },
                {
                    name: "Button #2",
                    scope: 'button',
                    value: {
                        openTypography: 1,
                        size: {
                            md: 14,
                            unit: "px"
                        },
                        family: "Lato",
                        height: {
                            unit: "px",
                            md: "17"
                        },
                        spacing: {
                            unit: "px",
                            md: "0",
                            xs: "0"
                        },
                        type: "sans-serif",
                        weight: 700
                    }
                }
            ],
        },

    },

}

export const DEFAULTBREAKINGPOINTS = {
    sm: 540,
    md: 720,
    lg: 960,
    xl: 1140,
}