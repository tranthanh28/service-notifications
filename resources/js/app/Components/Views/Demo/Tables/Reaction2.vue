<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <app-breadcrumb page-title="Reaction" :directory="$t('datatables')" :icon="'grid'"/>
      </div>
      <div class="col-sm-12 col-md-6 breadcrumb-side-button">
        <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
          <button type="button"
                  class="btn btn-primary btn-with-shadow"
                  data-toggle="modal"
                  @click="dialogFormVisible = true">
            {{ $t('add') }}
          </button>
        </div>
      </div>
    </div>
    <el-table
        :data="data.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
        style="width: 100%">
      <el-table-column
          label="name"
          prop="name">
      </el-table-column>
      <el-table-column
          label="status"
          prop="status">
      </el-table-column>
      <el-table-column
          label="created"
          prop="created_at">
      </el-table-column>
      <el-table-column
          align="right">
        <template slot="header" slot-scope="scope">
          <el-input
              v-model="search"
              size="mini"
              placeholder="Type to search"/>
        </template>
        <template slot-scope="scope">
          <el-button
              size="mini"
              @click="handleDowload(scope.row)">Dowload
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
        background
        layout="prev, pager, next"
        @current-change="handleCurrentChange"
        :current-page.sync="currentPage"
        :page-size="perPage"
        :total="totalPages">
    </el-pagination>


    <el-dialog title="Reaction" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="name" :label-width="formLabelWidth">
          <el-input v-model="form.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="File" :label-width="formLabelWidth">
          <el-upload
              action=""
              class="upload-demo"
              style="height: 50px;"
              ref="upload"
              :on-change="handleImport"
              :auto-upload="false">
            <el-button slot="trigger" size="small" type="primary">select file</el-button>
          </el-upload>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
    <el-button @click="dialogFormVisible = false">Cancel</el-button>
    <el-button type="primary" @click="handleAddReaction">submit</el-button>
  </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      //Pagination
      totalPages: 0,
      perPage: 10,
      currentPage: 1,
      search: '',

      gridData: [{
        date: '2016-05-02',
        name: 'John Smith',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-04',
        name: 'John Smith',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-01',
        name: 'John Smith',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }, {
        date: '2016-05-03',
        name: 'John Smith',
        address: 'No.1518,  Jinshajiang Road, Putuo District'
      }],
      dialogTableVisible: false,
      dialogFormVisible: false,
      form: {
        name: '',
        post_ids: "",
      },
      formLabelWidth: '120px',
      fileContent: '',
      errors: "",
      data: [],
    }
  },
  created() {
    this.getListReactions(this.page)
  },
  methods: {
    handleAddReaction() {
      this.$refs.upload.clearFiles();
      this.form.post_ids = this.fileContent
      axios.post('/api/reaction', this.form).then((response) => {
        this.stopLoading()
        this.getListReactions()
        this.dialogFormVisible = false
        this.form = {
          name: '',
          post_ids: "",
        }
      }).catch((error) => {
        this.stopLoading()
        this.$notify.error({
          title: 'Error',
          message: 'failed'
        });
        this.errors = error.response.data.errors;
      })

    },
    handleImport(file) {
      this.uploadFile = file
      let reader = new FileReader()
      reader.readAsText(this.uploadFile.raw)
      reader.onload = async (e) => {
        try {
          this.fileContent = e.target.result
        } catch (err) {
          console.log(`Load JSON file error: ${err.message}`)
        }
      }
    },
    handleDowload(row) {
      let dataDowload = {
        file_name: row.file_name
      }
      axios.post('/api/reaction/export-excel', dataDowload, {
        responseType: 'blob'
      }).then((response) => {
        const url = URL.createObjectURL(new Blob([response.data], {
          type: 'application/vnd.ms-excel'
        }))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', dataDowload.file_name)
        document.body.appendChild(link)
        link.click()
      }).catch((error) => {
        this.stopLoading()
        this.$notify.error({
          title: 'Error',
          message: 'failed'
        });
      })
    },
    handleEditUser() {
      this.startLoading()
      let dataEdit = {
        status: this.form.status ? 1 : 0
      }
      axios.put(`/api/adm/${this.form.id}`, dataEdit).then(response => {
        this.stopLoading()
        this.currentUser.status = dataEdit.status
        this.dialogFormVisible = false
        this.$notify({
          title: 'Success',
          message: 'update successfully',
          type: 'success'
        });
      }).catch(error => {
        this.stopLoading()
        this.dialogFormVisible = false
        this.handleErrorNotPermission(error)
      })
    },
    handleCurrentChange(val) {
      this.$router.push({path: '/manage/users', query: {page: val, status: this.currentTab}});
      this.getListReactions(val, this.currentTab)
    },
    getListReactions(page = 1) {
      this.startLoading()
      axios.get(`/api/reaction/?page=${page}`).then((response) => {
        this.stopLoading()
        this.data = response.data.data
        // this.totalPages = response.data.data.total
        // this.perPage = response.data.data.per_page
        // this.currentPage = response.data.data.current_page
      }).catch((errors) => {
        this.stopLoading()
        this.handleErrorNotPermission(errors)
      })
    }
  }

}
</script>
