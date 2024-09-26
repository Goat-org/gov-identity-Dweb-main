<?php 
include("includes/admin_header.php");
include("server/get_admin_register.php");
?>
<body>
    <header>
        <h1>Home Affairs: Registration</h1>
        <img class="logo" src="resources/Home.jpeg" alt="Home Affairs Logo">
    </header>
    <nav></nav>
    <main id="reg-login-form">
        <!------------- Website Messages ----------->
        <p class="text-center" id="webMessageSuccess"><?php if(isset($_GET['success'])){ echo htmlspecialchars($_GET['success']); } ?></p>
        <p class="text-center" id="webMessageError"><?php if(isset($_GET['error'])){ echo htmlspecialchars($_GET['error']); } ?></p>
        <p class="text-center" id="message"></p>

        <form id="reg-form" action="server/admin_register.php" method="POST">
            <label for="adminFirstName">First Name(s)</label>
            <input type="text" id="adminFirstName" name="firstName" placeholder="Enter First Name(s)" required>

            <label for="adminSurname">Surname</label>
            <input type="text" id="adminSurname" name="surname" placeholder="Enter Surname" required>

            <label for="adminEmail">Email</label>
            <input type="email" id="adminEmail" name="email" placeholder="Enter Email" required>

            <label for="adminPassword">Password</label>
            <input type="password" id="adminPassword" name="password" placeholder="Enter Password" required>

            <label for="adminRePassword">Re-enter Password</label>
            <input type="password" id="adminRePassword" name="rePassword" placeholder="Re-enter Password" required>

            <button type="submit" class="registerBtn" id="adminRegisterBtn">Submit</button>
        </form>
        <p>Already have an Admin account? <a href="admin_login.php">Login here</a></p>
    </main>

    <script>
        // Check if MetaMask is injected
        if (typeof window.ethereum !== 'undefined') {
            const web3 = new Web3(window.ethereum);
            ethereum.request({ method: 'eth_requestAccounts' })
                .then(accounts => {
                    console.log('Connected to MetaMask:', accounts[0]);
                })
                .catch(error => {
                    console.error('User denied account access', error);
                });
        } else {
            alert('Please install MetaMask to interact with this application.');
        }

        // ABI of the smart contract
        const abi = [
            {
                "constant": false,
                "inputs": [
                    { "name": "_adminFirstName", "type": "string" },
                    { "name": "_adminSurname", "type": "string" },
                    { "name": "_adminEmail", "type": "string" },
                    { "name": "_adminPassword", "type": "bytes32" }
                ],
                "name": "submitForm",
                "outputs": [],
                "payable": false,
                "stateMutability": "nonpayable",
                "type": "function"
            },
            {
                "constant": true,
                "inputs": [
                    { "name": "_userAddress", "type": "address" }
                ],
                "name": "getUserData",
                "outputs": [
                    { "name": "", "type": "string" },
                    { "name": "", "type": "string" },
                    { "name": "", "type": "string" },
                    { "name": "", "type": "bytes32" }
                ],
                "payable": false,
                "stateMutability": "view",
                "type": "function"
            },
            {
                "constant": true,
                "inputs": [],
                "name": "taskCount",
                "outputs": [
                    { "name": "", "type": "uint256" }
                ],
                "payable": false,
                "stateMutability": "view",
                "type": "function"
            }
        ];

        // Address of the deployed contract
        const contractAddress = '0x466d60Efb44EB03bF88C208a6485AaD738031799'; // Replace with your contract address

        // Create contract instance
        const contract = new web3.eth.Contract(abi, contractAddress);

        // Form submission handler
        document.getElementById('reg-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const fName = document.getElementById('adminFirstName').value;
            const lName = document.getElementById('adminSurname').value;
            const adminEmail = document.getElementById('adminEmail').value;
            const adminPassword = document.getElementById('adminPassword').value;
            const adminRePassword = document.getElementById('adminRePassword').value;

            // Check if the passwords match
            if (adminPassword !== adminRePassword) {
                alert('Passwords do not match!');
                return;
            }

            // Hash the password before submitting
            const hashedPassword = web3.utils.sha3(adminPassword);

            web3.eth.getAccounts().then(accounts => {
                contract.methods.submitForm(fName, lName, adminEmail, hashedPassword).send({ from: accounts[0] })
                .then(receipt => {
                    console.log('Transaction receipt:', receipt);
                    alert('Form submitted successfully!');
                })
                .catch(error => {
                    console.error('Error submitting form:', error);
                    alert('Error submitting form');
                });
            });
        });

        // Retrieve user data
        document.getElementById('retrieveForm')?.addEventListener('submit', function(event) {
            event.preventDefault();

            const userAddress = document.getElementById('userAddress').value;

            contract.methods.getUserData(userAddress).call()
            .then(userData => {
                const fName = userData[0];
                const lName = userData[1];
                const adminEmail = userData[2];

                document.getElementById('reg-form').innerHTML = `
                    <h3>User Data</h3>
                    <p><strong>First Name:</strong> ${fName}</p>
                    <p><strong>Last Name:</strong> ${lName}</p>
                    <p><strong>Email:</strong> ${adminEmail}</p>
                `;
            })
            .catch(error => {
                console.error('Error retrieving user data:', error);
                alert('Error retrieving user data');
            });
        });
    </script>
</body>
<?php 
include("includes/admin_footer.php");
?>
