export default [
    {
        header: "Apps & Pages"
    },
    {
        title: "User Managements",
        icon: "UserIcon",
        children: [
            {
                title: "Admin",
                route: ""
            },
            {
                title: "Staff",
                route: ""
            }
        ]
    },
    {
        title: "Customer Managements",
        icon: "UserIcon",
        children: [
            {
                title: "All Customers",
                route: ""
            },
            {
                title: "Customer Reports",
                route: ""
            }
        ]
    },
    {
        title: "Vendor Management",
        icon: "UserIcon",
        children: [
            {
                title: " All Vendors",
                route: ""
            },
            {
                title: "Add Vendors",
                route: ""
            },
            {
                title: "Pending Vendors",
                route: ""
            },
            {
                title: "Suspend Vendors",
                route: ""
            },
            {
                title: "New Vendor Request",
                route: ""
            },
        ]
    },



    {
        title: "Product Settings",
        icon: "ShoppingBagIcon",
        children: [

              {
                title: 'Category',
                route: 'category',

              },
              {
                title: 'Brand',
                route: 'brand',

              },{
                title: 'Unit',
                route: 'unit',

              },{
                title: 'Country',
                route: 'country',


              },{
                title: 'Currency',
                route: 'currency',

              },

              {
                title: 'Variation',
                route: 'variation',

              },
        ]
    },
    {
        title: "Product Managements",
        icon: "SettingsIcon",
        children: [

              {
                title: 'Add New Product',
                route: '',

              },
              {
                title: 'All Product',
                route: '',

              },
              {
                title: 'Pending Product',
                route: '',

              },
              {
                title: 'Daft Product',
                route: '',


              }
        ]
    },


    {
        title: "Order Managements",
        icon: "ShoppingCartIcon",
        children: [

              {
                title: ' New Orders',
                route: '',

              },
              {
                title: 'Proccessing Orders',
                route: '',

              },
              {
                title: ' Complete Orders',
                route: '',

              },
              {
                title: ' Cancel Orders',
                route: '',


              }
        ]
    },

    {
        title: "Transaction Managements",
        icon: "DollarSignIcon",
        children: [

              {
                title: 'Vendor Pending  Commission',
                route: '',

              },
              {
                title: 'Vendor Complete Commission',
                route: '',

              },
              {
                title: 'Withdraw Requests',
                route: '',

              },

        ]
    },

    {
        title: "Pages",
        icon: "FileIcon",
        children: [
            {
                title: "Authentication",
                icon: "CircleIcon",
                children: [
                    {
                        title: "Login v1",
                        route: "auth-login-v1",
                        target: "_blank"
                    },
                    {
                        title: "Login v2",
                        route: "auth-login-v2",
                        target: "_blank"
                    },
                    {
                        title: "Register v1",
                        route: "auth-register-v1",
                        target: "_blank"
                    },
                    {
                        title: "Register v2",
                        route: "auth-register-v2",
                        target: "_blank"
                    },
                    {
                        title: "Forgot Password v1",
                        route: "auth-forgot-password-v1",
                        target: "_blank"
                    },
                    {
                        title: "Forgot Password v2",
                        route: "auth-forgot-password-v2",
                        target: "_blank"
                    },
                    {
                        title: "Reset Password v1",
                        route: "auth-reset-password-v1",
                        target: "_blank"
                    },
                    {
                        title: "Reset Password v2",
                        route: "auth-reset-password-v2",
                        target: "_blank"
                    }
                ]
            },
            {
                title: "Account Settings",
                route: "pages-account-setting"
            },

        ]
    },
    {
        title: "Invoice",
        icon: "FileTextIcon",
        children: [
            {
                title: "List",
                route: "apps-invoice-list"
            },
            {
                title: "Preview",
                route: { name: "apps-invoice-preview", params: { id: 4987 } }
            },
            {
                title: "Edit",
                route: { name: "apps-invoice-edit", params: { id: 4987 } }
            },
            {
                title: "Add",
                route: { name: "apps-invoice-add" }
            }
        ]
    },
];
