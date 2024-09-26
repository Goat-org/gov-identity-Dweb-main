pragma solidity ^0.5.16;

contract UserRegistry {
    struct User {
        string adminFirstName;
        string adminSurname;
        string adminEmail;
        bytes32 adminPassword;
    }

    mapping(address => User) public users;

    event UserRegistered(address userAddress, string email);

    // Register a new user
    function registerUser(
        string memory _adminFirstName, 
        string memory _adminSurname, 
        string memory _adminEmail, 
        bytes32 _adminPassword
    ) 
        public 
    {
        require(bytes(users[msg.sender].adminEmail).length == 0, "User already registered");
        
        users[msg.sender] = User(_adminFirstName, _adminSurname, _adminEmail, _adminPassword);
        emit UserRegistered(msg.sender, _adminEmail);
    }

    // Login user by checking email and password hash
    function loginUser(string memory _adminEmail, bytes32 _adminPassword) public view returns (bool) {
        User memory user = users[msg.sender];
        return (
            keccak256(abi.encodePacked(user.adminEmail)) == keccak256(abi.encodePacked(_adminEmail)) &&
            user.adminPassword == _adminPassword
        );
    }

    // Get user details by address
    function getUser(address _userAddress) public view returns (string memory, string memory, string memory) {
        User memory user = users[_userAddress];
        require(bytes(user.adminEmail).length != 0, "User not found");
        return (user.adminFirstName, user.adminSurname, user.adminEmail);
    }
}
