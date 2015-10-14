using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Data.SqlClient;
using System.Data;

public partial class log : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {

    }
    protected void Button1_Click(object sender, EventArgs e)
    {
        SqlConnection mycon = new SqlConnection("Data Source=.\\SQLEXPRESS;AttachDbFilename=|DataDirectory|\\saurabh.mdf;Integrated Security=True;User Instance=True");
      
        mycon.Open();
        string cmdstr = "select count(*) from sp where firstname ='" + TextBox1.Text + "'";
        SqlCommand checkuser = new SqlCommand(cmdstr, mycon);
        int temp = Convert.ToInt32(checkuser.ExecuteScalar().ToString());
        if (temp == 1)
        {
            string cmdstr2 = "select mobileno from sp where firstname='" + TextBox1.Text + "'";
            SqlCommand last = new SqlCommand(cmdstr2, mycon);
           // string lastname = last.ExecuteScalar().ToString();
            string mobileno = last.ExecuteScalar().ToString();
           // if (lastname == TextBox2.Text)
            if (mobileno == TextBox2.Text)
            {
                Session["new"] = TextBox1.Text;
                // Response.Write("userid and password are invalid");
                Response.Redirect("Default.aspx");
            }
            else
            {
                Label1.Visible = true;
                Label1.Text = "invalid mobileno......";
            }
        }
        else
        {
            Label1.Visible = true;
            Label1.Text = "invalid firstname......";
        }
    }
}